<?php

namespace App\Controller\InternalAPI\V1\WebAdmin\CMS\HomePage;

use App\Controller\InternalAPI\V1\WebAdmin\BaseWebAdminController;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage\NewBannerGroupModal;
use App\Service\InternalAPI\CMS\Banner\IBannerGroupService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/internal-api/v1/web-admin/cms/home-page/main-banner-config')]
class MainBannerConfigController extends BaseWebAdminController
{
    #[Route('/new-group', name: 'ia_v1_cw_cms_home_page_main_banner_new_group', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewMainBannerGroup(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IBannerGroupService $bannerGroupService): JsonResponse
    {
        try{
            $rawData = $request->request->all();
            $groupModal = $serializer->denormalize($rawData,NewBannerGroupModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            if(!empty($rawData['bannerContents']))
            {
                $images = $request->files->get('bannerContents') ?? [];
                if(!empty($images)){
                    foreach ($images as $index=>$imageArray) {
                        if(!empty($groupModal->bannerContents[$index])){
                            $groupModal->bannerContents[$index]->imageFile = $imageArray['imageFile'] ?? null;
                            $groupModal->bannerContents[$index]->mobileImageFile = $imageArray['mobileImageFile'] ?? null;
                        }
                    }
                }
            }
            $resp = $bannerGroupService->addNewBannerGroup($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }
}