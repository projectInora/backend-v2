<?php

namespace App\Controller\InternalAPI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseInternalAPIController extends AbstractController
{
    use InternalAPIErrorCodes;
    const USER_DEVICE_VERIFY = 'USER_DEVICE_VERIFY';
    protected function getJsonApiResponseHeaders(JsonResponse $apiResponse): JsonResponse
    {
        $apiResponse->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        $apiResponse->headers->set('Access-Control-Allow-Origin', '*');
        $apiResponse->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $apiResponse->headers->set('content-type', 'application/json');
        return $apiResponse;
    }

    /**
     * @param ConstraintViolationList $violationList
     * @return array[]
     */
    protected function getValidatorErrors(ConstraintViolationList $violationList) : array
    {
        $errorMessages = [];
        if (count($violationList) > 0) {

            foreach ($violationList as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
        }
        return ['errors'=>$errorMessages];
    }
}