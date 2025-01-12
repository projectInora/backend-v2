<?php

namespace App\Service\InternalAPI\CMS\Banner;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage\NewBannerContentModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage\NewBannerGroupModal;
use App\Entity\Authentication\AuthUser;
use App\Entity\CMS\Banner\BannerContent;
use App\Entity\CMS\Banner\BannerGroup;
use App\Entity\CMS\Banner\BannerGroupType;
use App\Entity\CMS\Base\ButtonContent;
use App\Entity\Image\Images;
use App\Service\Base\IBaseImageService;
use App\Service\InternalAPI\CMS\BaseCMSService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BannerGroupService extends BaseCMSService implements IBannerGroupService
{
    const GT_HOME_MAIN = "HOME_MAIN_BANNER_GROUP";
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private IBaseImageService $imageService;
    private ParameterBagInterface $parameterBag;
    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator, SerializerInterface $serializer, IBaseImageService $imageService, ParameterBagInterface $parameterBag)
    {
        parent::__construct($em);
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->imageService = $imageService;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param AuthUser $user
     * @param NewBannerGroupModal $bannerGroupModal
     * @return array
     */
    function addNewBannerGroup(AuthUser $user, NewBannerGroupModal $bannerGroupModal) : array
    {
        try {
            $errors = $this->validator->validate($bannerGroupModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $groupType = $this->em->getRepository(BannerGroupType::class)->findOneBy(['code'=>$bannerGroupModal->groupTypeCode, 'isActive'=>true]);
            if($groupType == null){
                return ['error'=>$this->getErrorMessage('CWE_ER020'), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $bannerGroup = new BannerGroup();
            $bannerGroup->setGroupType($groupType);
            $bannerGroup->setMainTitle($bannerGroupModal->mainTitle);
            $bannerGroup->setSubTitle($bannerGroupModal->subTitle);
            $bannerGroup->setShortDescription($bannerGroupModal->shortDescription);
            $bannerGroup->setDescription($bannerGroupModal->description);
            $bannerGroup->setActionButtonEnabled(intval($bannerGroupModal->isActionButtonEnable) == 1);
            $bannerGroup->setGroupOrder($bannerGroupModal->groupOrder);
            $bannerGroup->setValidFrom(
                !empty($bannerGroupModal->validFrom)
                    ? $this->getDateTimeFromString($bannerGroupModal->validFrom)
                    : null
            );
            $bannerGroup->setValidTill(
                !empty($bannerGroupModal->validTill)
                    ? $this->getDateTimeFromString($bannerGroupModal->validTill)
                    : null
            );
            $this->em->persist($bannerGroup);

            if($bannerGroupModal->actionButtonModal != null){
                $actionButton = new ButtonContent();
                $actionButton->setText($bannerGroupModal->actionButtonModal->text);
                $actionButton->setHrefLink($bannerGroupModal->actionButtonModal->hrefLink);
                $actionButton->setNewTab(intval($bannerGroupModal->actionButtonModal->isNewTab) == 1);
                $actionButton->setValidFrom(
                    !empty($bannerGroupModal->actionButtonModal->validFrom)
                        ? $this->getDateTimeFromString($bannerGroupModal->actionButtonModal->validFrom)
                        : null
                );
                $actionButton->setValidTill(
                    !empty($bannerGroupModal->actionButtonModal->validTill)
                        ? $this->getDateTimeFromString($bannerGroupModal->actionButtonModal->validTill)
                        : null
                );
                $this->em->persist($actionButton);
                $bannerGroup->setActionButton($actionButton);
            }
            $bannerGroup->setCreatedBy($user);
            $bannerGroup->setUpdatedBy($user);
            $this->em->persist($bannerGroup);

            $errors = [];
            if(!empty($bannerGroupModal->bannerContents)){
                $err = $this->addNewBannerContents($user, $bannerGroup, $bannerGroupModal->bannerContents);
                $this->em->persist($bannerGroup);
                if(!empty($err)){
                    $errors = array_merge($errors, $err);
                }
            }

            $this->em->persist($bannerGroup);
            $this->em->flush();
            return ['error'=>null, 'formErrors' => $errors, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param BannerGroup $bannerGroup
     * @param array $bannerContents
     * @param bool $isFlush
     * @return array
     */
    function addNewBannerContents(AuthUser $user, BannerGroup $bannerGroup, array $bannerContents, bool $isFlush = false): array
    {
        $errors = [];
        foreach($bannerContents as $contentModal){
            try{
                $imageFile = $contentModal->imageFile;
                if(empty($imageFile)){
                    $errors[] = ['error'=>['errorCode'=>$this->getErrorMessage('BEI00001'), 'formErrors' => [], 'status' => false]];
                    continue;
                }
                $resp = $this->addNewBannerContent($user, $bannerGroup, $contentModal);
                if(!$resp['status']){
                    $errors[] = $resp;
                }
            }
            catch (\Exception $e) {
                $errors[] = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false];
            }
        }
        return $errors;
    }

    /**
     * @param AuthUser $user
     * @param BannerGroup $bannerGroup
     * @param NewBannerContentModal $contentModal
     * @param bool $isFlush
     * @return array
     */
    function addNewBannerContent(AuthUser $user, BannerGroup $bannerGroup, NewBannerContentModal $contentModal, bool $isFlush = false): array
    {
        try{
            $errors = $this->validator->validate($contentModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $fileName = $user->getUuid().'_'.$bannerGroup->getId().'_'.uniqid();
            $image = $this->imageService->uploadImageLocally($contentModal->imageFile, $this->parameterBag->get('cnt.uploads.cms.banner.images'), $fileName);
            if(!($image instanceof Images))
            {
                return $image;
            }
            $bannerContent = new BannerContent();
            $bannerContent->setBannerGroup($bannerGroup);
            $bannerContent->setAlt($contentModal->alt);
            $bannerContent->setDisplayOrder($contentModal->displayOrder);
            $bannerContent->setClickable(intval($contentModal->isClickable) == 1);
            $bannerContent->setClickLink($contentModal->clickLink);
            $bannerContent->setCreatedBy($user);
            $bannerContent->setUpdatedBy($user);
            $bannerContent->setWebImage($image);

            if(!empty($contentModal->mobileImageFile))
            {
                $fileName = $user->getUuid().'_'.$bannerGroup->getId().'_M_'.uniqid();
                $mobileImage = $this->imageService->uploadImageLocally($contentModal->mobileImageFile, $this->parameterBag->get('cnt.uploads.cms.banner.images'), $fileName);
                if($mobileImage instanceof Image)
                {
                    $bannerContent->setMobileImage($mobileImage);
                }
            }
            $bannerContent->setValidFrom(
                !empty($contentModal->validFrom)
                    ? $this->getDateTimeFromString($contentModal->validFrom)
                    : null
            );
            $bannerContent->setValidTill(
                !empty($contentModal->validTill)
                    ? $this->getDateTimeFromString($contentModal->validTill)
                    : null
            );
            $this->em->persist($bannerContent);
            if($isFlush){
                $this->em->flush();
            }
            return ['status'=>true, 'message'=>'banner content added.'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }



    function getHomePageMainBannerGroup(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'groupType' => self::GT_HOME_MAIN,
            'dateFilter' => true
        ];

        $bannerGroups = $this->em->getRepository(BannerGroup::class)->filterBy($filterPara);
        $bannerGroupContent = [];
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'arrayResult' => true,
            'select'=> ['p.id', 'p.displayOrder', 'p.alt', 'p.isClickable', 'p.clickLink', "DATE_FORMAT(p.validFrom, '%Y-%m-%d %H:%i:%s') as validFrom",
                "DATE_FORMAT(p.validTill, '%Y-%m-%d %H:%i:%s') as validTill",
                'wI.name as webImgName', 'wI.extension as webImgExtension', 'COALESCE(wI.cdnPath, wI.localPath) AS webImgPath',
                'mI.name as mobImgName', 'mI.extension as mobImgExtension', 'COALESCE(mI.cdnPath, mI.localPath) AS mobImgPath'
            ]
        ];
        $now = $this->getCurrentDateTime();
        foreach ($bannerGroups as $bannerGroup) {
            $filterPara['bannerGroupId'] = $bannerGroup->getId();
            $bannerContents = $this->em->getRepository(BannerContent::class)->filterBy($filterPara);
            $bannerGroupContent[] = [
                'id' => $bannerGroup->getId(),
                'mainTitle' => $bannerGroup->getMainTitle(),
                'subTitle' => $bannerGroup->getSubTitle(),
                'shortDescription' => $bannerGroup->getShortDescription(),
                'description' => $bannerGroup->getDescription(),
                'groupOrder' => $bannerGroup->getGroupOrder(),
                'isActionButtonEnabled' => $bannerGroup->isActionButtonEnabled(),
                'actionButton' => $bannerGroup->getActionButton() != null
                && $now > $bannerGroup->getActionButton()->getValidFrom() && $now <= $bannerGroup->getActionButton()->getValidTill() ? [
                    'text'=> $bannerGroup->getActionButton()->getText(),
                    'hrefLink'=> $bannerGroup->getActionButton()->getHrefLink(),
                    'isNewTab'=> $bannerGroup->getActionButton()->isNewTab(),
                ] : null,
                'contents' => $bannerContents,
            ];
        }
        return $bannerGroupContent;
    }
}