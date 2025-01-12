<?php

namespace App\Controller\InternalAPI\V1\WebAdmin\FishDataSet;

use App\Controller\InternalAPI\V1\WebAdmin\BaseWebAdminController;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Service\InternalAPI\CMS\Banner\IBannerGroupService;
use App\Service\InternalAPI\WebAdmin\FishDataSet\IFishClassificationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/internal-api/v1/web-admin/fish-dataset/fish-classification')]
class FishClassificationController extends BaseWebAdminController
{
    #[Route('/new-kingdoms', name: 'ia_v1_cw_fish_dataset_fish_classification_new_kingdoms', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewKingdoms(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewKingdoms($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-phylum', name: 'ia_v1_cw_fish_dataset_fish_classification_new_phylum', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewPhylum(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewMultiPhylum($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-class', name: 'ia_v1_cw_fish_dataset_fish_classification_new_class', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewPhylumClasses(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewPhylumClasses($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-class-orders', name: 'ia_v1_cw_fish_dataset_fish_classification_new_class_orders', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewClassOrders(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewClassOrders($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-families', name: 'ia_v1_cw_fish_dataset_fish_classification_new_families', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewFamilies(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewFamilies($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-genus', name: 'ia_v1_cw_fish_dataset_fish_classification_new_genus', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewGenus(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewMultiGenus($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }

    #[Route('/new-species', name: 'ia_v1_cw_fish_dataset_fish_classification_new_species', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewSpecies(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishClassificationService $classificationService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $classificationService->addNewMultiSpecies($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }
}