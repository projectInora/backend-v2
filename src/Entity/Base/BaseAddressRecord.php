<?php

namespace App\Entity\Base;
use App\Entity\Territory\City;
use App\Entity\Territory\Country;
use Doctrine\ORM\Mapping as ORM;
#[ORM\MappedSuperclass]
class BaseAddressRecord extends BaseFullRecord
{
    #[ORM\ManyToOne]
    private ?City $city = null;

    #[ORM\ManyToOne]
    private ?Country $country = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $phoneNo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addressName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullAddress = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $altitude = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNo(): ?string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(?string $phoneNo): static
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    public function getAddressName(): ?string
    {
        return $this->addressName;
    }

    public function setAddressName(?string $addressName): static
    {
        $this->addressName = $addressName;

        return $this;
    }

    public function getFullAddress(): ?string
    {
        return $this->fullAddress;
    }

    public function setFullAddress(?string $fullAddress): static
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function setAltitude(?float $altitude): static
    {
        $this->altitude = $altitude;

        return $this;
    }
}