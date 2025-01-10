<?php

namespace App\Service\InternalAPI\CMS\Page;

use App\Entity\Authentication\AuthUser;
use App\Entity\CMS\Page\Page;
use App\Entity\Meta\Image;
use App\Service\Base\IBaseImageService;
use App\Service\InternalAPI\CMS\BaseCMSService;
use App\Service\InternalAPI\WebAdmin\CMS\Page\NewPopularTourCategoryImageModel;
use App\Service\InternalAPI\WebAdmin\CMS\Page\NewPopularTourCategoryModel;
use App\Service\InternalAPI\WebAdmin\CMS\Page\PagePopularDestinations;
use App\Service\InternalAPI\WebAdmin\CMS\Page\PageSearchTabs;
use App\Service\InternalAPI\WebAdmin\CMS\Page\PageTourCategory;
use App\Service\InternalAPI\WebAdmin\CMS\Page\TourCategory;
use App\Service\InternalAPI\WebAdmin\CMS\Page\UserReview;
use App\Service\InternalAPI\WebAdmin\CMS\Page\UserReviewImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PageService extends BaseCMSService implements IPageService
{
    const P_HOME = "HOME";
    const R_MODE = "PLATFORM";

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

    function getHomePageSearchTabs(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'page' => self::P_HOME,
            'arrayResult' => true,
            'select' => [
                'p.id', 'COALESCE(p.displayName, sT.name) AS name', 'sT.code',
                'p.displayOrder'
            ]
        ];
        return $this->em->getRepository(PageSearchTabs::class)->filterBy($filterPara);
    }

    function getHomePageTourCategories(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'page' => self::P_HOME,
            'arrayResult' => true,
            'select' => [
                'p.id', 'COALESCE(p.displayName, tc.name) AS category',
                'p.noOfDestinations', 'p.noOfActivities', 'p.displayOrder',
                "DATE_FORMAT(p.validFrom, '%Y-%m-%d %H:%i:%s') as validFrom",
                "DATE_FORMAT(p.validTill, '%Y-%m-%d %H:%i:%s') as validTill",
                'wI.name as webImgName', 'wI.extensionType as webImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS webImgPath',
                'mI.name as mobImgName', 'mI.extensionType as mobImgExtension', 'COALESCE(mI.cloudPath, mI.localPath) AS mobImgPath'
            ]
        ];
        return $this->em->getRepository(PageTourCategory::class)->filterBy($filterPara);
    }

    function getHomePagePopularDestinations(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'dateFilter' => true,
            'page' => self::P_HOME,
            'arrayResult' => true,
            'select' => [
                'p.id', 'COALESCE(p.displayName, d.name) AS destination',
                'tc.name as category', 'p.displayOrder',
                "DATE_FORMAT(p.validFrom, '%Y-%m-%d %H:%i:%s') as validFrom",
                "DATE_FORMAT(p.validTill, '%Y-%m-%d %H:%i:%s') as validTill",
                'wI.name as webImgName', 'wI.extensionType as webImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS webImgPath',
                'mI.name as mobImgName', 'mI.extensionType as mobImgExtension', 'COALESCE(mI.cloudPath, mI.localPath) AS mobImgPath'
            ]
        ];
        return $this->em->getRepository(PagePopularDestinations::class)->filterBy($filterPara);
    }

    function getHomePagePlatformUserReviews(): array
    {
        $filterPara = [
            'isActive' => true,
            'status' => true,
            'reviewMode' => self::R_MODE,
            'start' => 0,
            'length' => 10,
            'arrayResult' => true,
            'select' => [
                'p.id', 'p.ratingOutOfFive', 'p.title', 'p.review',
                "CONCAT(up.firstName, ' ', up.lastName) AS fullName",
                'c.name as country',
                "DATE_FORMAT(p.createdAt, '%Y-%m-%d %H:%i:%s') as createdAt",
                'wI.name as profileImgName', 'wI.extensionType as profileImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS profileImgPath',
            ]
        ];

        $reviews = $this->em->getRepository(UserReview::class)->filterBy($filterPara);
        $repo = $this->em->getRepository(UserReviewImage::class);
        $para = [
            'isActive' => true,
            'status' => true,
            'select' => [
                'p.id', 'p.remark', 'p.displayOrder',
                'wI.name as webImgName', 'wI.extensionType as webImgExtension', 'COALESCE(wI.cloudPath, wI.localPath) AS webImgPath',
            ]
        ];
        foreach ($reviews as $index => $review) {
            $para['reviewId'] = $review['id'];
            $reviews[$index]['images'] = $repo->filterBy($para);
        }
        return $reviews;
    }

    /**
     * @param AuthUser $user
     * @param NewPopularTourCategoryModel $newPopularTourCategoryModel
     * @return array
     */
    function newPopularTourCategoryModel(AuthUser $user, NewPopularTourCategoryModel $newPopularTourCategoryModel): array
    {
        try {
            // Validate input model
            $errors = $this->validator->validate($newPopularTourCategoryModel);
            if (count($errors) > 0) {
                return [
                    'error' => $this->getErrorMessage('CWE0000Y'),
                    'formErrors' => $this->getValidatorErrors($errors),
                    'status' => false,
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                ];
            }

            $tourCategoryRepo = $this->em->getRepository(TourCategory::class);
            $tourCategoryDetails = $tourCategoryRepo->findOneBy(['code' => $newPopularTourCategoryModel->tourCategoryCode]);

            $pageRepo = $this->em->getRepository(Page::class);
            $pageDetails = $pageRepo->findOneBy(['code' => $newPopularTourCategoryModel->pageCode]);




            if (!$tourCategoryDetails) {
                return [
                    'error' => $this->getErrorMessage('CWE0000Z'), // Handle invalid category code
                    'formErrors' => [],
                    'status' => false,
                    'statusCode' => Response::HTTP_NOT_FOUND,
                ];
            }

            $tourCategory = new PageTourCategory();
            $tourCategory->setTourCategory($tourCategoryDetails);
            $tourCategory->setDisplayName($newPopularTourCategoryModel->displayName);
            $tourCategory->setNoOfActivities($newPopularTourCategoryModel->noOfActivities);
            $tourCategory->setNoOfDestinations($newPopularTourCategoryModel->noOfDestinations);
            $tourCategory->setDisplayOrder($newPopularTourCategoryModel->displayOrder);
            $tourCategory->setPage($pageDetails);
            $tourCategory->setCreatedBy($user);
            $tourCategory->setUpdatedBy($user);



            $contentErrors = [];
            if (!empty($newPopularTourCategoryModel->imgContent)) {
                $contentErrors = $this->addNewPopularTourContents($user, $tourCategory, $newPopularTourCategoryModel->imgContent);
            }

            $this->em->persist($tourCategory);
            $this->em->flush();

            return [
                'error' => null,
                'formErrors' => $contentErrors,
                'status' => true,
                'statusCode' => Response::HTTP_OK,
            ];
        } catch (\Exception $e) {
            return [
                'error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()],
                'formErrors' => [],
                'status' => false,
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    /**
     * @param AuthUser $user
     * @param PageTourCategory $pageTour
     * @param array $imgContent
     * @return array
     */
    function addNewPopularTourContents(AuthUser $user, PageTourCategory $pageTour, array $imgContent): array
    {
        $errors = [];
        foreach($imgContent as $content){
            try{
                $imageFile = $content['imageFile'];
                if(empty($imageFile)){
                    $errors[] = ['error'=>['errorCode'=>$this->getErrorMessage('BEI00001'), 'formErrors' => [], 'status' => false]];
                    continue;
                }
                $mobileImageFile = $content['mobileImageFile'];
                unset($content['mobileImageFile']);
                unset($content['imageFile']);
                $contentModal = $this->serializer->denormalize($content, NewPopularTourCategoryImageModel::class);
                $contentModal->imageFile = $imageFile;
                $contentModal->mobileImageFile = $mobileImageFile;
                $resp = $this->addNewPopularTourContent($user, $pageTour, $contentModal);
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
     * @param PageTourCategory $pageTour
     * @param NewPopularTourCategoryImageModel $contentModel
     * @param bool $isFlush
     * @return array
     *
     */
    function addNewPopularTourContent(AuthUser $user, PageTourCategory $pageTour, NewPopularTourCategoryImageModel $contentModel ,bool $isFlush = false): array
    {
        try {
            $errors = $this->validator->validate($contentModel);
            if (count($errors) > 0) {
                return [
                    'error' => $this->getErrorMessage('CWE0000Y'),
                    'formErrors' => $this->getValidatorErrors($errors),
                    'status' => false,
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                ];
            }

            $fileName = $user->getUuid() . '_' . $pageTour->getId() . '_' . uniqid();
            $image = $this->imageService->uploadImageLocally(
                $contentModel->imageFile,
                $this->parameterBag->get('cnt.uploads.cms.banner.images'),
                $fileName
            );

            if (!$image instanceof Image) {
                return $image;
            }

            $tourContent = new PageTourCategory();
            $tourContent->setDisplayOrder($contentModel->displayOrder ?? 0);
            $tourContent->setCreatedBy($user);
            $tourContent->setUpdatedBy($user);
            $tourContent->setWebBannerImage($image);

            if (!empty($contentModel->mobileImageFile)) {
                $mobileFileName = $user->getUuid() . '_' . $pageTour->getId() . '_M_' . uniqid();
                $mobileImage = $this->imageService->uploadImageLocally(
                    $contentModel->mobileImageFile,
                    $this->parameterBag->get('cnt.uploads.cms.banner.images'),
                    $mobileFileName
                );
                if ($mobileImage instanceof Image) {
                    $tourContent->setMobileBannerImage($mobileImage);
                }
            }

            $tourContent->setValidFrom(
                !empty($contentModal->validFrom)
                    ? $this->getDateTimeFromString($contentModal->validFrom)
                    : null
            );
            $tourContent->setValidTill(
                !empty($contentModal->validTill)
                    ? $this->getDateTimeFromString($contentModal->validTill)
                    : null
            );

            $this->em->persist($tourContent);
            if($isFlush){
                $this->em->flush();
            }

            return ['status' => true, 'message' => 'Banner content added successfully.'];
        } catch (\Exception $e) {
            return [
                'error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()],
                'status' => false,
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
    }