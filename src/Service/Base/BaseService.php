<?php

namespace App\Service\Base;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseService implements IBaseService
{

    use ServiceErrorCodes;
    protected string $timeZone = "Asia/Colombo";

    protected EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ConstraintViolationList $violationList
     * @return array[]
     */
    public function getValidatorErrors(ConstraintViolationList $violationList) : array
    {
        $errorMessages = [];
        if (count($violationList) > 0) {

            foreach ($violationList as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
        }
        return ['errors'=>$errorMessages];
    }

    /**
     * @throws Exception
     */
    public function getCurrentDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone($this->timeZone));
    }

    /**
     * @param string $datetimeString
     * @return \DateTimeImmutable
     * @throws Exception
     */
    public function getDateTimeFromString(string $datetimeString): \DateTimeImmutable
    {
        return new \DateTimeImmutable($datetimeString, new \DateTimeZone($this->timeZone));
    }
}