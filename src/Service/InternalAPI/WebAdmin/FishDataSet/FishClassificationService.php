<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCClassModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCFamilyModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCGenusModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCKingdomModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCOrderModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCPhylumModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewCSpeciesModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;
use App\Entity\FishDataSet\Classification\FishClassificationClass;
use App\Entity\FishDataSet\Classification\FishClassificationFamily;
use App\Entity\FishDataSet\Classification\FishClassificationGenus;
use App\Entity\FishDataSet\Classification\FishClassificationKingdom;
use App\Entity\FishDataSet\Classification\FishClassificationOrder;
use App\Entity\FishDataSet\Classification\FishClassificationPhylum;
use App\Entity\FishDataSet\Classification\FishClassificationSpecies;
use App\Service\InternalAPI\BaseInternalAPIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FishClassificationService extends BaseInternalAPIService implements IFishClassificationService
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    private array $kingdoms = [];
    private array $phylum = [];
    private array $phylumClass = [];
    private array $classOrders = [];
    private array $families = [];
    private array $genus = [];

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator,
                                SerializerInterface $serializer)
    {
        parent::__construct($em, $container);
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    private function getKingdomByCode(string $code): ?FishClassificationKingdom
    {
        try{
            if(!empty($this->kingdoms[$code])){
                return $this->kingdoms[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationKingdom::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->kingdoms[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getPhylumByCode(string $code): ?FishClassificationPhylum
    {
        try{
            if(!empty($this->phylum[$code])){
                return $this->phylum[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationPhylum::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->phylum[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getPhylumClassByCode(string $code): ?FishClassificationClass
    {
        try{
            if(!empty($this->phylumClass[$code])){
                return $this->phylumClass[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationClass::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->phylumClass[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getClassOrderByCode(string $code): ?FishClassificationOrder
    {
        try{
            if(!empty($this->classOrders[$code])){
                return $this->classOrders[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationOrder::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->classOrders[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getOrderFamilyByCode(string $code): ?FishClassificationFamily
    {
        try{
            if(!empty($this->families[$code])){
                return $this->families[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationFamily::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->families[$code] = $extModal;
                return $extModal;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }

    private function getGenusByCode(string $code): ?FishClassificationGenus
    {
        try{
            if(!empty($this->genus[$code])){
                return $this->genus[$code];
            }
            $extModal = $this->em->getRepository(FishClassificationGenus::class)->findOneBy(['code' => $code, 'isActive' => true]);
            if($extModal != null){
                $this->genus[$code] = $extModal;
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
     * @return array
     */
    function addNewKingdoms(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array
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
                $singleModal = $this->serializer->denormalize($modal,NewCKingdomModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewKingdom($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewKingdom(AuthUser $user, NewCKingdomModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->getKingdomByCode($code);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('BEI00003'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationKingdom();
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
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewMultiPhylum(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array
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
                $singleModal = $this->serializer->denormalize($modal,NewCPhylumModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewPhylum($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewPhylum(AuthUser $user, NewCPhylumModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $kingdom = $this->getKingdomByCode($modal->kingdomCode);
            if($kingdom == null){
                return ['error'=>$this->getErrorMessage('WAE_FC001'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationPhylum::class)->findOneBy(['code' => $code, 'isActive' => true, 'kingdom'=>$kingdom]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC002'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationPhylum();
            $newModal->setKingdom($kingdom);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewPhylumClasses(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array
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
                $singleModal = $this->serializer->denormalize($modal,NewCClassModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewPhylumClass($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewPhylumClass(AuthUser $user, NewCClassModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $phylum = $this->getPhylumByCode($modal->phylumCode);
            if($phylum == null){
                return ['error'=>$this->getErrorMessage('WAE_FC003'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationClass::class)->findOneBy(['code' => $code, 'isActive' => true, 'phylum'=>$phylum]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC004'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationClass();
            $newModal->setPhylum($phylum);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewClassOrders(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array
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
                $singleModal = $this->serializer->denormalize($modal,NewCOrderModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewClassOrder($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewClassOrder(AuthUser $user, NewCOrderModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $phylumClass = $this->getPhylumClassByCode($modal->classCode);
            if($phylumClass == null){
                return ['error'=>$this->getErrorMessage('WAE_FC005'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationOrder::class)->findOneBy(['code' => $code, 'isActive' => true, 'cClass'=>$phylumClass]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC006'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationOrder();
            $newModal->setCClass($phylumClass);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewFamilies(AuthUser $user, NewMultiRecordModal $multiRecordModal): array
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
                $singleModal = $this->serializer->denormalize($modal,NewCFamilyModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewFamily($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewFamily(AuthUser $user, NewCFamilyModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $classOrder = $this->getClassOrderByCode($modal->orderCode);
            if($classOrder == null){
                return ['error'=>$this->getErrorMessage('WAE_FC007'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationFamily::class)->findOneBy(['code' => $code, 'isActive' => true, 'cOrder'=>$classOrder]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC008'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationFamily();
            $newModal->setCOrder($classOrder);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewMultiGenus(AuthUser $user, NewMultiRecordModal $multiRecordModal): array
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
                $singleModal = $this->serializer->denormalize($modal,NewCGenusModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewGenus($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewGenus(AuthUser $user, NewCGenusModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $family = $this->getOrderFamilyByCode($modal->familyCode);
            if($family == null){
                return ['error'=>$this->getErrorMessage('WAE_FC009'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationGenus::class)->findOneBy(['code' => $code, 'isActive' => true, 'family'=>$family]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC010'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationGenus();
            $newModal->setFamily($family);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecordModal
     * @return array
     */
    function addNewMultiSpecies(AuthUser $user, NewMultiRecordModal $multiRecordModal): array
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
                $singleModal = $this->serializer->denormalize($modal,NewCSpeciesModal::class);
                $resp[$singleModal->code ?? $singleModal->name] = $this->addNewSpecies($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewSpecies(AuthUser $user, NewCSpeciesModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error' => $this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $genus = $this->getGenusByCode($modal->genusCode);
            if($genus == null){
                return ['error'=>$this->getErrorMessage('WAE_FC011'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $code = $modal->code ?? strtoupper($modal->name);
            $extModal = $this->em->getRepository(FishClassificationSpecies::class)->findOneBy(['code' => $code, 'isActive' => true, 'genus'=>$genus]);
            if ($extModal) {
                return ['error' => $this->getErrorMessage('WAE_FC012'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishClassificationSpecies();
            $newModal->setGenus($genus);
            $newModal->setCode($code);
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['error' => ['errorCode' => 'CWE0000X', 'message' => $e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}