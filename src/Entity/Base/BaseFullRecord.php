<?php

namespace App\Entity\Base;

use App\Entity\Authentication\AuthUser;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\MappedSuperclass]
class BaseFullRecord extends BaseRecord
{
    const TIMEZONE = 'Asia/Colombo';
    #[ORM\Column(options: ["default"=>true])]
    private ?bool $isDeleted = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $deletedBy = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->isDeleted = false;
        parent::__construct();
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedBy(): ?AuthUser
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?AuthUser $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
}
