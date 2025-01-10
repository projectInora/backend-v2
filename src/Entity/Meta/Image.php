<?php

namespace App\Entity\Meta;

use App\Entity\Base\BaseStatus;
use App\Repository\Meta\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\Table(name: "meta_image")]
class Image extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 20,nullable: true)]
    private ?string $extensionType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localPath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cloudPath = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $fullImageName = null;

    #[ORM\Column(nullable: true)]
    private ?float $aspDivWidth = null;

    #[ORM\Column(nullable: true)]
    private ?float $aspDivHeight = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid("MI_"));
        $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        $this->setLocalPath($name);
        $this->setExtensionType(pathinfo($name, PATHINFO_EXTENSION));

        return $this;
    }

    public function getExtensionType(): ?string
    {
        return $this->extensionType;
    }

    public function setExtensionType(string $extensionType): self
    {
        $this->extensionType = $extensionType;

        return $this;
    }

    public function getLocalPath(): ?string
    {
        return $this->localPath;
    }

    public function setLocalPath(?string $name, $path = null): self
    {
        $this->localPath = $name != null ? ($path == null)?'images/common-image/' . $name : $path : null;

        return $this;
    }

    public function getCloudPath(): ?string
    {
        return $this->cloudPath;
    }

    public function setCloudPath(?string $cloudPath): self
    {
        $this->cloudPath = $cloudPath;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt =  new \DateTimeImmutable();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFullImageName(): ?string
    {
        return $this->fullImageName;
    }

    public function setFullImageName(string $fullImageName): static
    {
        $this->fullImageName = $fullImageName;

        return $this;
    }

    public function getAspDivWidth(): ?float
    {
        return $this->aspDivWidth;
    }

    public function setAspDivWidth(?float $aspDivWidth): static
    {
        $this->aspDivWidth = $aspDivWidth;

        return $this;
    }

    public function getAspDivHeight(): ?float
    {
        return $this->aspDivHeight;
    }

    public function setAspDivHeight(?float $aspDivHeight): static
    {
        $this->aspDivHeight = $aspDivHeight;

        return $this;
    }


}
