<?php

namespace App\Controller\InternalAPI\V1\WebAdmin\FishDataSet;

use App\Controller\InternalAPI\V1\WebAdmin\BaseWebAdminController;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Service\InternalAPI\WebAdmin\FishDataSet\IFishEnvironmentService;
use App\Service\InternalAPI\WebAdmin\WebAdminGlobalConst;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/internal-api/v1/web-admin/fish-dataset/fish-environment')]
class FishEnvironmentController extends BaseWebAdminController
{
    use WebAdminGlobalConst;

    #[Route('/new-climate-zones', name: 'ia_v1_cw_fish_dataset_fish_environment_new_climate_zones', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewClimateZone(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishEnvironmentService $environmentService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $environmentService->addNewEnvironmentRecords($this->getUser(), $groupModal, $this->ENV_CLIMATE_ZONE);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-milieu', name: 'ia_v1_cw_fish_dataset_fish_environment_new_milieu', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewMilieu(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishEnvironmentService $environmentService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $environmentService->addNewEnvironmentRecords($this->getUser(), $groupModal, $this->ENV_MILIEU);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-depth-range', name: 'ia_v1_cw_fish_dataset_fish_environment_new_depth_range', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewDepthRanges(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishEnvironmentService $environmentService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $environmentService->addNewEnvironmentRecords($this->getUser(), $groupModal, $this->ENV_DEPTH_RANGE);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-dist-range', name: 'ia_v1_cw_fish_dataset_fish_environment_new_dist_range', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewDistributionRanges(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishEnvironmentService $environmentService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $environmentService->addNewEnvironmentRecords($this->getUser(), $groupModal, $this->ENV_DIST_RANGE);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }
}