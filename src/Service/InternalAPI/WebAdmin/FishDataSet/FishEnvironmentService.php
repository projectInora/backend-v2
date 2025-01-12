<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCKingdomModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewEnvironmentModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;
use App\Entity\FishDataSet\Classification\FishClassificationKingdom;
use App\Entity\FishDataSet\Environment\FishEnvironmentClimateZone;
use App\Entity\FishDataSet\Environment\FishEnvironmentDepthRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentDistributionRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentMilieu;
use App\Service\InternalAPI\BaseInternalAPIService;
use App\Service\InternalAPI\WebAdmin\FishDataSet\IFishEnvironmentService;
use App\Service\InternalAPI\WebAdmin\WebAdminGlobalConst;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FishEnvironmentService extends BaseInternalAPIService implements IFishEnvironmentService
{
    use WebAdminGlobalConst;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private array $climateZones = [];
    private array $depthRanges = [];
    private array $milieus = [];
    private array $dRanges = [];

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator,
                                SerializerInterface $serializer)
    {
        parent::__construct($em, $container);
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    private function getClimateZonesByCode(string $code): ?FishEnvironmentClimateZone
    {
        try{
            if(!empty($this->depthRanges[$code])){
                return $this->depthRanges[$code];
            }
            $extModal = $this->em->getRepository(FishEnvironmentClimateZone::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->depthRanges[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getMilieuByCode(string $code): ?FishEnvironmentClimateZone
    {
        try{
            if(!empty($this->depthRanges[$code])){
                return $this->depthRanges[$code];
            }
            $extModal = $this->em->getRepository(FishEnvironmentClimateZone::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->depthRanges[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getDepthRangeByCode(string $code): ?FishEnvironmentMilieu
    {
        try{
            if(!empty($this->milieus[$code])){
                return $this->milieus[$code];
            }
            $extModal = $this->em->getRepository(FishEnvironmentMilieu::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->milieus[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getDistributionRangeByCode(string $code): ?FishEnvironmentDistributionRange
    {
        try{
            if(!empty($this->dRanges[$code])){
                return $this->dRanges[$code];
            }
            $extModal = $this->em->getRepository(FishEnvironmentDistributionRange::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->dRanges[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @param string $mode
     * @return array
     */
    function addNewEnvironmentRecords(AuthUser $user, NewMultiRecordModal $multiRecordModal, string $mode) : array
    {
        try {
            $errors = $this->validator->validate($multiRecordModal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $uniqueData = array_values(array_reduce($multiRecordModal->modals ?? [], function ($carry, $item) {
                $carry[$item['code'] ?? $item['name']] = $item; // Use 'code' as the key to ensure uniqueness
                return $carry;
            }, []));

            $resp = [];
            foreach ($uniqueData as $modal) {
                $singleModal = $this->serializer->denormalize($modal,NewEnvironmentModal::class);
                $key = $singleModal->code ?? $singleModal->name;
                switch ($mode) {
                    case $this->ENV_CLIMATE_ZONE:
                        $resp[$key] = $this->addNewClimateZone($user, $singleModal);
                        break;

                    case $this->ENV_MILIEU:
                        $resp[$key] = $this->addNewMilieu($user, $singleModal);
                        break;

                    case $this->ENV_DEPTH_RANGE:
                        $resp[$key] = $this->addNewDepthRanges($user, $singleModal);
                        break;

                    case $this->ENV_DIST_RANGE:
                        $resp[$key] = $this->addNewDistributionRanges($user, $singleModal);
                        break;
                }
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            dd($e);
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewEnvironmentModal $modal
     * @return array|string[]
     */
    function addNewClimateZone(AuthUser $user, NewEnvironmentModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->getClimateZonesByCode($code);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('WAE_FC013'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishEnvironmentClimateZone();
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status'=>'success'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewEnvironmentModal $modal
     * @return array|string[]
     */
    function addNewMilieu(AuthUser $user, NewEnvironmentModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->getMilieuByCode($code);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('WAE_FC014'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishEnvironmentMilieu();
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status'=>'success'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewEnvironmentModal $modal
     * @return array|string[]
     */
    function addNewDepthRanges(AuthUser $user, NewEnvironmentModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->getDepthRangeByCode($code);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('WAE_FC015'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishEnvironmentDepthRange();
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status'=>'success'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewEnvironmentModal $modal
     * @return array|string[]
     */
    function addNewDistributionRanges(AuthUser $user, NewEnvironmentModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->getDistributionRangeByCode($code);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('WAE_FC016'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishEnvironmentDistributionRange();
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status'=>'success'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}