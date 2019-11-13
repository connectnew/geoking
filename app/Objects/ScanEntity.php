<?php

namespace App\Objects;

/**
 * Class ScanEntity
 * @package App\Objects
 */
class ScanEntity
{
    /** @var string|null */
    private $name;
    /** @var string|null */
    private $phone;
    /** @var string|null */
    private $country;
    /** @var string|null */
    private $province;
    /** @var string|null */
    private $city;
    /** @var string|null */
    private $address;
    /** @var string|null */
    private $postalCode;
    /** @var string|null */
    private $webSite;
    /** @var bool */
    private $isLocationVerified = false;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @param string|null $province
     */
    public function setProvince(?string $province): void
    {
        $this->province = $province;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    /**
     * @param string|null $webSite
     */
    public function setWebSite(?string $webSite): void
    {
        $this->webSite = $webSite;
    }

    /**
     * @return bool
     */
    public function isLocationVerified(): bool
    {
        return $this->isLocationVerified;
    }

    /**
     * @param bool $isLocationVerified
     */
    public function setIsLocationVerified(bool $isLocationVerified): void
    {
        $this->isLocationVerified = $isLocationVerified;
    }

    /**
     * @return string|null
     */
    public function getFullAddress(): ?string
    {
        if (null !== $this->getCountry()
            || null !== $this->getProvince()
            || null !== $this->getCity()
            || null !== $this->getAddress()
            || null !== $this->getPostalCode()
        ) {
            return sprintf(
                '%s %s %s, %s, %s',
                $this->getCountry() ?? '',
                $this->getProvince() ?? '',
                $this->getCity() ?? '',
                $this->getAddress() ?? '',
                $this->getPostalCode() ?? ''
            );
        }

        return null;
    }
}