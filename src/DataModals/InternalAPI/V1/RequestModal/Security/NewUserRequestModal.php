<?php

namespace App\DataModal\InternalAPI\V1\RequestModal\Security;
use Symfony\Component\Validator\Constraints as Assert;
class NewUserRequestModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $firstName;

    public ?string $lastName;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public string $phoneNumber;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $nic;
}