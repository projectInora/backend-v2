<?php

namespace App\Service\InternalAPI;

use App\Service\Base\BaseService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseInternalAPIService extends BaseService
{
    protected ContainerBagInterface $container;

    /**
     * @param EntityManagerInterface $em
     * @param ContainerBagInterface $container
     */
    public function __construct(EntityManagerInterface $em, ContainerBagInterface $container)
    {
        $this->container = $container;
        parent::__construct($em);
    }
}