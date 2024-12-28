<?php

namespace App\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class BaseStatus
{
    const TIMEZONE = 'Asia/Colombo';
    #[ORM\Column(options: ["default"=>true])]
    private ?bool $isActive = null;
    #[ORM\Column(options: ["default"=>true])]
    private ?bool $status = null;
    #[ORM\Column(options: ["default"=>1])]
    private ?int $version = null;

    public function __construct()
    {
        $this->isActive = true;
        $this->status = true;
        $this->version = 1;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }
}
