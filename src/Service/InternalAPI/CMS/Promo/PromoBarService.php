<?php

namespace App\Service\InternalAPI\CMS\Promo;

use App\Entity\Authentication\AuthUser;
use App\Entity\CMS\Base\ButtonContent;
use App\Entity\CMS\Page\Page;
use App\Entity\CMS\Promo\PromoBar;
use App\Entity\CMS\Promo\PromoBarContent;
use App\Entity\CMS\Promo\PromoBarContentImage;
use App\Entity\CMS\Promo\PromoType;
use App\Entity\Meta\Image;
use App\Service\Base\IBaseImageService;
use App\Service\InternalAPI\CMS\BaseCMSService;
use App\Service\InternalAPI\WebAdmin\CMS\Promo\NewPromoBarContentImageModal;
use App\Service\InternalAPI\WebAdmin\CMS\Promo\NewPromoBarContentModal;
use App\Service\InternalAPI\WebAdmin\CMS\Promo\NewPromoBarModal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PromoBarService extends BaseCMSService implements IPromoBarService
{
    const P_HOME = "HOME";
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private IBaseImageService $imageService;
    private ParameterBagInterface $parameterBag;
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, SerializerInterface $serializer, IBaseImageService $imageService, ParameterBagInterface $parameterBag)
    {
        parent::__construct($em);
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->imageService = $imageService;
        $this->parameterBag = $parameterBag;
    }

    function getHomePageProBarGroups(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'page' => self::P_HOME,
            'dateFilter' => true,
            'arrayResult'=>true,
            'select'=>[
                'p.id', 'COALESCE(p.displayTitle, p.name) AS title',
                'p.isDisplayTitleVisible', 'p.isSlidable', 'p.displayOrder', 'p.slideDirection',
                'p.subTitle', 'p.isSubVisible', 'p.contentPerRow', 'p.rowCountPerBar',
                'p.cntDivAspectWidth', 'p.cntDivAspectHeight', 'pt.name as promoType', 'pt.code as promoTypeCode',
            ]
        ];

        $promoBars = [];
        $promoBarGroups = $this->em->getRepository(PromoBar::class)->filterBy($filterPara);

        $filterPara = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'page' => self::P_HOME,
            'arrayResult'=>true,
            'select'=>[
                'p.id', 'p.title','p.description', 'p.isClickable', 'p.clickLink',
                'p.subTitle', 'p.shortDescription', 'p.displayOrder',
                'ab.text as buttonText', 'ab.hrefLink as buttonHrefLink', 'ab.isNewTab as buttonIsNewTab',
                'wI.name as webImgName', 'wI.extensionType as webImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS webImgPath',
                'mI.name as mobImgName', 'mI.extensionType as mobImgExtension', 'COALESCE(mI.cloudPath, mI.localPath) AS mobImgPath'
            ]
        ];
        $filterPara2 = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'page' => self::P_HOME,
            'arrayResult'=>true,
            'select'=>[
                'p.id', 'p.aspDivWidth','p.aspDivHeight', 'p.displayOrder',
                'wI.name as webImgName', 'wI.extensionType as webImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS webImgPath',
                'mI.name as mobImgName', 'mI.extensionType as mobImgExtension', 'COALESCE(mI.cloudPath, mI.localPath) AS mobImgPath'
            ]
        ];
        $repo = $this->em->getRepository(PromoBarContent::class);
        $repo2 = $this->em->getRepository(PromoBarContentImage::class);
        foreach ($promoBarGroups as $promoBarGroup) {
            $filterPara['promoBarId'] = $promoBarGroup['id'];
            $promoBarContents = $repo->filterBy($filterPara);
            $promoContents = [];
            foreach ($promoBarContents as $promoBarContent) {
                $filterPara2['contentId'] = $promoBarContent['id'];
                $promoBarContent['images'] = $repo2->filterBy($filterPara2);
                $promoContents[] = $promoBarContent;
            }
            $promoBarGroup['barContents'] = $promoContents;
            $promoBars[] = $promoBarGroup;
        }

        return $promoBars;
    }

    /**
     * @param AuthUser $user
     * @param NewPromoBarModal $promoBarModal
     * @return array
     */
    function addNewPromoBar(AuthUser $user, NewPromoBarModal $promoBarModal) : array
    {
        try {
            $errors = $this->validator->validate($promoBarModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $promoType = $this->em->getRepository(PromoType::class)->findOneBy(['code'=>$promoBarModal->promoTypeCode, 'isActive'=>true]);
            if($promoType == null){
                return ['error'=>$this->getErrorMessage('CWE_ER021'), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $page = $this->em->getRepository(Page::class)->findOneBy(['code'=>$promoBarModal->pageCode, 'isActive'=>true]);
            if($page == null){
                return ['error'=>$this->getErrorMessage('CWE_ER022'), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $promoBar = new PromoBar();
            $promoBar->setPromoType($promoType);
            $promoBar->setPage($page);
            $promoBar->setDisplayOrder($promoBarModal->displayOrder);
            $promoBar->setName($promoBarModal->name);
            $promoBar->setDisplayTitle($promoBarModal->displayTitle);
            $promoBar->setDisplayTitleVisible(intval($promoBarModal->isDisplayTitleVisible) == 1);
            $promoBar->setSlidable(intval($promoBarModal->isSlidable) == 1);
            $promoBar->setSlideDirection($promoBarModal->slideDirection);
            $promoBar->setSubTitle($promoBarModal->subTitle);
            $promoBar->setSubVisible(intval($promoBarModal->isSubVisible) == 1);
            $promoBar->setContentPerRow(intval($promoBarModal->contentPerRow));
            $promoBar->setRowCountPerBar(intval($promoBarModal->rowCountPerBar));
            $promoBar->setCntDivAspectWidth(intval($promoBarModal->cntDivAspectWidth));
            $promoBar->setCntDivAspectHeight(intval($promoBarModal->cntDivAspectHeight));
            $promoBar->setCreatedBy($user);
            $promoBar->setUpdatedBy($user);
            $promoBar->setValidFrom(
                !empty($promoBarModal->validFrom)
                    ? $this->getDateTimeFromString($promoBarModal->validFrom)
                    : null
            );
            $promoBar->setValidTill(
                !empty($promoBarModal->validTill)
                    ? $this->getDateTimeFromString($promoBarModal->validTill)
                    : null
            );
            $this->em->persist($promoBar);

            $errors = [];
            if(!empty($promoBarModal->barContents)){
                $err = $this->addNewPromoBarContents($user, $promoBar, $promoBarModal->barContents);
                $this->em->persist($promoBar);
                if(!empty($err)){
                    $errors = array_merge($errors, $err);
                }
            }
            $this->em->persist($promoBar);
            $this->em->flush();
            return ['error'=>null, 'formErrors' => $errors, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param PromoBar $promoBar
     * @param array $barContents
     * @param bool $isFlush
     * @return array
     */
    function addNewPromoBarContents(AuthUser $user, PromoBar $promoBar, array $barContents, bool $isFlush = false): array
    {
        $errors = [];
        foreach($barContents as $barContent){
            try{
                $imageFile = $barContent['imageFile'] ?? null;
                $mobileImageFile = $barContent['mobileImageFile'] ?? null;
                if(isset($barContent['imageFile'])){
                    unset($barContent['imageFile']);
                }
                if(isset($barContent['mobileImageFile'])){
                    unset($barContent['mobileImageFile']);
                }
                $contentModal = $this->serializer->denormalize($barContent, NewPromoBarContentModal::class);
                $contentModal->imageFile = $imageFile;
                $contentModal->mobileImageFile = $mobileImageFile;
                $resp = $this->addNewPromoBarContent($user, $promoBar, $contentModal);
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
     * @param PromoBar $promoBar
     * @param NewPromoBarContentModal $contentModal
     * @param bool $isFlush
     * @return array
     */
    function addNewPromoBarContent(AuthUser $user, PromoBar $promoBar, NewPromoBarContentModal $contentModal, bool $isFlush = false): array
    {
        try{
            $errors = $this->validator->validate($contentModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $barContent = new PromoBarContent();
            $barContent->setPromoBar($promoBar);
            $barContent->setTitle($contentModal->title);
            $barContent->setSubTitle($contentModal->subTitle);
            $barContent->setDisplayOrder(intval($contentModal->displayOrder));
            $barContent->setDescription($contentModal->description);
            $barContent->setShortDescription($contentModal->shortDescription);
            $barContent->setClickable(intval($contentModal->isClickable) == 1);
            $barContent->setClickLink($contentModal->clickLink);
            $barContent->setCreatedBy($user);
            $barContent->setUpdatedBy($user);

            if($contentModal->actionButton != null){
                $actionButton = new ButtonContent();
                $actionButton->setText($contentModal->actionButton->text);
                $actionButton->setHrefLink($contentModal->actionButton->hrefLink);
                $actionButton->setNewTab(intval($contentModal->actionButton->isNewTab) == 1);
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
                $barContent->setActionButton($actionButton);
            }

            if(!empty($contentModal->imageFile)){
                $fileName = $user->getUuid().'_'.$promoBar->getId().'_'.uniqid();
                $image = $this->imageService->uploadImageLocally($contentModal->imageFile, $this->parameterBag->get('cnt.uploads.cms.banner.images'), $fileName);
                if($image instanceof Image)
                {
                    $barContent->setDefaultBanner($image);
                }
            }
            if(!empty($contentModal->mobileImageFile))
            {
                $fileName = $user->getUuid().'_'.$promoBar->getId().'_M_'.uniqid();
                $mobileImage = $this->imageService->uploadImageLocally($contentModal->mobileImageFile, $this->parameterBag->get('cnt.uploads.cms.banner.images'), $fileName);
                if($mobileImage instanceof Image)
                {
                    $barContent->setDefaultMobBanner($mobileImage);
                }
            }
            $barContent->setValidFrom(
                !empty($contentModal->validFrom)
                    ? $this->getDateTimeFromString($contentModal->validFrom)
                    : null
            );
            $barContent->setValidTill(
                !empty($contentModal->validTill)
                    ? $this->getDateTimeFromString($contentModal->validTill)
                    : null
            );
            $this->em->persist($barContent);

            $errors = [];
            if(!empty($contentModal->contentImages)){
                $err = $this->addPromoBarContentImages($user, $barContent, $contentModal->contentImages);
                $this->em->persist($promoBar);
                if(!empty($err)){
                    $errors = array_merge($errors, $err);
                }
            }

            if($isFlush){
                $this->em->flush();
            }
            return ['status'=>true, 'message'=>'bar content added.', 'formErrors'=>$errors];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param PromoBarContent $barContent
     * @param array $contentImages
     * @param bool $isFlush
     * @return array
     */
    function addPromoBarContentImages(AuthUser $user, PromoBarContent $barContent, array $contentImages, bool $isFlush = false): array
    {
        $errors = [];
        foreach($contentImages as $contentImage){
            try{
                $imageFile = $contentImage['imageFile'];
                if(empty($imageFile)){
                    $errors[] = ['error'=>['errorCode'=>$this->getErrorMessage('BEI00001'), 'formErrors' => [], 'status' => false]];
                    continue;
                }
                $mobileImageFile = $contentImage['mobileImageFile'];
                unset($contentImage['mobileImageFile']);
                unset($contentImage['imageFile']);
                $imageModel = $this->serializer->denormalize($contentImage, NewPromoBarContentImageModal::class);
                $imageModel->imageFile = $imageFile;
                $imageModel->mobileImageFile = $mobileImageFile;
                $resp = $this->addNewProBarContentImage($user, $barContent, $imageModel);
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
     * @param PromoBarContent $barContent
     * @param NewPromoBarContentImageModal $imageModal
     * @param bool $isFlush
     * @return array
     */
    function addNewProBarContentImage(AuthUser $user, PromoBarContent $barContent, NewPromoBarContentImageModal $imageModal, bool $isFlush = false): array
    {
        try{
            $errors = $this->validator->validate($imageModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $fileName = $user->getUuid().'_'.$barContent->getId().'_'.uniqid();
            $image = $this->imageService->uploadImageLocally($imageModal->imageFile, $this->parameterBag->get('cnt.uploads.destination.images'), $fileName);
            if(!($image instanceof Image))
            {
                return $image;
            }
            $contentImage = new PromoBarContentImage();
            $contentImage->setPromoContent($barContent);
            $contentImage->setImage($image);
            $contentImage->setAspDivWidth($imageModal->aspDivWidth != null ? floatval($imageModal->aspDivWidth) : null);
            $contentImage->setAspDivHeight($imageModal->aspDivHeight != null ? floatval($imageModal->aspDivHeight) : null);

            if(!empty($imageModal->mobileImageFile))
            {
                $fileName = $user->getUuid().'_'.$barContent->getId().'_M_'.uniqid();
                $mobileImage = $this->imageService->uploadImageLocally($imageModal->mobileImageFile, $this->parameterBag->get('cnt.uploads.destination.images'), $fileName);
                if($mobileImage instanceof Image)
                {
                    $contentImage->setMobileImage($mobileImage);
                }
            }
            $contentImage->setValidFrom(
                !empty($imageModal->validFrom)
                    ? $this->getDateTimeFromString($imageModal->validFrom)
                    : null
            );
            $contentImage->setValidTill(
                !empty($imageModal->validTill)
                    ? $this->getDateTimeFromString($imageModal->validTill)
                    : null
            );
            $contentImage->setDisplayOrder(intval($imageModal->displayOrder));
            $contentImage->setUpdatedBy($user);
            $contentImage->setCreatedBy($user);
            $this->em->persist($contentImage);
            if($isFlush){
                $this->em->flush();
            }
            return ['status'=>true, 'message'=>'content image added.'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}