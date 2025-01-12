<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewFishDataSetModal;
use App\Entity\Authentication\AuthUser;
use App\Entity\FishDataSet\FishDataSet;
use App\Service\InternalAPI\BaseInternalAPIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FishDataSetService extends BaseInternalApiService
{
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator)
    {
        parent::__construct($em, $container);
        $this->validator = $validator;
    }

    function addNewFishDataSet(AuthUser $user, NewFishDataSetModal $dataSetModal)
    {
        try{
            $errors = $this->validator->validate($dataSetModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $dataSet = new FishDataSet();
        }
        catch (\Exception $e){
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}