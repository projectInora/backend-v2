<?php

namespace App\Service\InternalAPI\Security;

use App\DataModal\InternalAPI\V1\RequestModal\Security\NewUserRequestModal;
use App\Entity\Authentication\AuthUser;
use App\Service\InternalAPI\BaseInternalAPIService;
use App\Service\InternalAPI\Security\IUserRegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationService extends BaseInternalAPIService implements IUserRegistrationService
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @param EntityManagerInterface $em
     * @param ContainerBagInterface $container
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator, SerializerInterface $serializer, UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($em, $container);
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    function registerNewUser(NewUserRequestModal $userRequestModal, ?AuthUser $user) : array
    {
        try {
            $errors = $this->validator->validate($userRequestModal);
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
}