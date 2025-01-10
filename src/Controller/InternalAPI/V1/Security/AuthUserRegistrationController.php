<?php

namespace App\Controller\InternalAPI\V1\Security;

use App\Controller\InternalAPI\BaseInternalAPIController;
use App\DataModal\InternalAPI\V1\RequestModal\Security\NewUserRequestModal;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/internal-api/v1/security/user-registration')]
class AuthUserRegistrationController extends BaseInternalAPIController
{
    #[Route('/register' , name:'ia_v1_cw_user_registration', methods:['POST'])]
    public function addNewTag(Request $request , ValidatorInterface $validator , SerializerInterface $serializer):JsonResponse
    {
        try{
            $data = $serializer->deserialize($request->getContent(),NewUserRequestModal::class, 'json');
            error_log('user details '.print_r($data,true));
            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $resp = ['error'=>$this->getErrorMessage('CWE00000'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
                return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
            }
            $resp = $newUserRegistration->newUserRegistration($data);
            $response = new JsonResponse($resp, $resp['statusCode'] ?? Response::HTTP_OK);
            return $this->getJsonApiResponseHeaders($response);
        }
        catch (\Exception $exception){
            $resp = ['error'=>['errorCode'=>'CWE0000X', 'message'=>$exception->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
            return $this->getJsonApiResponseHeaders(new JsonResponse($resp, Response::HTTP_BAD_REQUEST));
        }
    }
}