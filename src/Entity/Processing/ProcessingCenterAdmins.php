<?php

namespace App\Entity\Processing;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Repository\Processing\ProcessingCenterAdminsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessingCenterAdminsRepository::class)]
class ProcessingCenterAdmins extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $centerAdmin = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProcessingCenter $processingCenter = null;

    #[ORM\Column]
    private ?bool $isAccessAllowed = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCenterAdmin(): ?AuthUser
    {
        return $this->centerAdmin;
    }

    public function setCenterAdmin(?AuthUser $centerAdmin): static
    {
        $this->centerAdmin = $centerAdmin;

        return $this;
    }

    public function getProcessingCenter(): ?ProcessingCenter
    {
        return $this->processingCenter;
    }

    public function setProcessingCenter(?ProcessingCenter $processingCenter): static
    {
        $this->processingCenter = $processingCenter;

        return $this;
    }

    public function isAccessAllowed(): ?bool
    {
        return $this->isAccessAllowed;
    }

    public function setAccessAllowed(bool $isAccessAllowed): static
    {
        $this->isAccessAllowed = $isAccessAllowed;

        return $this;
    }
}
