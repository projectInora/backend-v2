<?php

namespace App\Service\InternalAPI\CMS;

use App\Service\Base\BaseService;
use Doctrine\ORM\EntityManagerInterface;

class BaseCMSService extends BaseService
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }
}