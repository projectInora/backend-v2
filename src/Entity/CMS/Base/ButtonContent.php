<?php

namespace App\Entity\CMS\Base;

use App\Entity\Base\BaseStatus;
use App\Repository\CMS\Base\ButtonContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ButtonContentRepository::class)]
#[ORM\Table(name: "cms_button_content")]
class ButtonContent extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $hrefLink = null;

    #[ORM\Column]
    private ?bool $isNewTab = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getHrefLink(): ?string
    {
        return $this->hrefLink;
    }

    public function setHrefLink(?string $hrefLink): static
    {
        $this->hrefLink = $hrefLink;

        return $this;
    }

    public function isNewTab(): ?bool
    {
        return $this->isNewTab;
    }

    public function setNewTab(bool $isNewTab): static
    {
        $this->isNewTab = $isNewTab;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeImmutable
    {
        return $this->validFrom;
    }

    public function setValidFrom(?\DateTimeImmutable $validFrom): static
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidTill(): ?\DateTimeImmutable
    {
        return $this->validTill;
    }

    public function setValidTill(?\DateTimeImmutable $validTill): static
    {
        $this->validTill = $validTill;

        return $this;
    }
}
