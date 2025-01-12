<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewEnvironmentModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewFishDataSetModal;
use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;
use App\Entity\FishDataSet\Classification\FishClassificationSpecies;
use App\Entity\FishDataSet\Environment\FishEnvironmentClimateZone;
use App\Entity\FishDataSet\Environment\FishEnvironmentDepthRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentDistributionRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentMilieu;
use App\Entity\FishDataSet\FishDataSet;
use App\Service\InternalAPI\BaseInternalAPIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FishDataSetService extends BaseInternalApiService implements IFishDataSetService
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container, ValidatorInterface $validator,
                                SerializerInterface $serializer)
    {
        parent::__construct($em, $container);
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param AuthUser $user
     * @param NewMultiRecordModal $multiRecord
     * @return array
     */
    function addNewFishDataSets(AuthUser $user, NewMultiRecordModal $multiRecord) : array
    {
        try{
            $errors = $this->validator->validate($multiRecord);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $uniqueData = array_values(array_reduce($multiRecordModal->modals ?? [], function ($carry, $item) {
                $carry[$item['scientificName'] ?? $item['name']] = $item;
                return $carry;
            }, []));

            $resp = [];
            foreach ($uniqueData as $modal) {
                $singleModal = $this->serializer->denormalize($modal,NewFishDataSetModal::class);
                $key = $singleModal->scientificName ?? $singleModal->name;
                $resp[$key] = $this->addNewFishDataSet($user, $singleModal);
            }
            return ['error'=>null, 'result' => $resp, 'status' => true, 'statusCode' => Response::HTTP_OK];
        }
        catch (\Exception $e){
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    function addNewFishDataSet(AuthUser $user, NewFishDataSetModal $modal): array
    {
        try {
            $errors = $this->validator->validate($modal);
            if (count($errors) > 0) {
                return ['error'=>$this->getErrorMessage('CWE0000Y'), 'formErrors' => $this->getValidatorErrors($errors), 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $extModal = $this->em->getRepository(FishDataSet::class)->findOneBy(['scientificName' => $modal->scientificName, 'status'=>true]);
            if($extModal != null){
                return ['error'=>$this->getErrorMessage('WAE_FC017'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $fishSpecies = $this->em->getRepository(FishClassificationSpecies::class)->findOneBy(['id' => $modal->classificationSpecies, 'status'=>true]);
            if($fishSpecies == null){
                return ['error'=>$this->getErrorMessage('WAE_FC018'), 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_BAD_REQUEST];
            }

            $newModal = new FishDataSet();
            $newModal->setName($modal->name);
            $newModal->setCreatedBy($user);
            $newModal->setNameSn($modal->nameSn);
            $newModal->setNameTa($modal->nameTa);
            $newModal->setNameInSrilanka($modal->nameInSrilanka);
            $newModal->setCommonNames($modal->commonNames ?? []);
            $newModal->setClassificationSpices($fishSpecies);
            $newModal->setBiology($modal->biology);
            $newModal->setLifeCycle($modal->lifeCycle);
            if(!empty($modal->envMilieu)) {
                $newModal->setEnvMilieu($this->em->getRepository(FishEnvironmentMilieu::class)->findOneBy(['id' => $modal->envMilieu, 'status'=>true]));
            }
            if(!empty($modal->envClimateZone)) {
                $newModal->setEnvClimateZone($this->em->getRepository(FishEnvironmentClimateZone::class)->findOneBy(['id' => $modal->envClimateZone, 'status'=>true]));
            }
            if(!empty($modal->envDepthRange)) {
                $newModal->setEnvDepthRange($this->em->getRepository(FishEnvironmentDepthRange::class)->findOneBy(['id' => $modal->envDepthRange, 'status'=>true]));
            }
            if(!empty($modal->envDistributionRange)) {
                $newModal->setEnvDistributionRange($this->em->getRepository(FishEnvironmentDistributionRange::class)->findOneBy(['id' => $modal->envDistributionRange, 'status'=>true]));
            }
            $newModal->setDistribution($modal->distribution);
            $newModal->setSizes($modal->sizes ?? []);
            $newModal->setWeights($modal->weights ?? []);
            $newModal->setAge($modal->age);
            $newModal->setShortDescription($modal->shortDescription);
            $newModal->setCommercialUses($modal->commercialUses ?? []);
            $newModal->setThreatToHuman($modal->threatToHuman);
            $newModal->setRedListStatus($modal->redListStatus);
            $newModal->setWeather($modal->weather);
            $newModal->setSalinity($modal->salinity);
            $newModal->setHumanUses($modal->humanUses ?? []);
            $this->em->persist($newModal);
            $this->em->flush();
            return ['status'=>'success'];
        }
        catch (\Exception $e) {
            return ['error'=>['errorCode'=>'CWE0000X', 'message'=>$e->getMessage()], 'formErrors' => [], 'status' => false, 'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}