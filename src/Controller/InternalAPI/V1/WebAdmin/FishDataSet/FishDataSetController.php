<?php

namespace App\Controller\InternalAPI\V1\WebAdmin\FishDataSet;

use App\Controller\InternalAPI\V1\WebAdmin\BaseWebAdminController;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Service\InternalAPI\WebAdmin\FishDataSet\IFishDataSetService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/internal-api/v1/web-admin/fish-dataset')]
class FishDataSetController extends BaseWebAdminController
{
    #[Route('/new-data-sets', name: 'ia_v1_cw_fish_dataset_new_data_Sets', methods: ['POST'])]
    #[IsGranted('ROLE_WEB_ADMIN')]
    public function addNewFishDataSets(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, IFishDataSetService $fishDataSetService): JsonResponse
    {
        try{
            $rawData = json_decode($request->getContent(), true);
            $groupModal = $serializer->denormalize($rawData,NewMultiRecordModal::class);
            $errors = $validator->validate($groupModal);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }

            $resp = $fishDataSetService->addNewFishDataSets($this->getUser(), $groupModal);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }
}