<?php

namespace App\Objects;

/**
 * Class ScanReport
 * @package App/Objects
 */
class ScanReport
{
    /** @var ScanEntity */
    private $scanEntity;
    /** @var ScanEntity[] */
    private $resEntities = [];
    /** @var int[] */
    private $scores = [];

    /**
     * ScanReport constructor.
     * @param ScanEntity $entity
     */
    public function __construct(ScanEntity $entity)
    {
        $this->scanEntity = $entity;
    }

    /**
     * @return ScanEntity
     */
    public function getScanEntity(): ScanEntity
    {
        return $this->scanEntity;
    }

    /**
     * @param string $apiName
     * @param ScanEntity $entity
     */
    public function addResEntity(string $apiName, ScanEntity $entity): void
    {
        $this->resEntities[$apiName] = $entity;
    }

    /**
     * @param string $apiName
     * @return ScanEntity
     */
    public function getResEntity(string $apiName): ScanEntity
    {
        if (!array_key_exists($apiName, $this->resEntities)) {
            $this->addResEntity($apiName, new ScanEntity());
        }
        return $this->resEntities[$apiName];
    }

    /**
     * @return string
     */
    public function getScanName(): string
    {
        return $this->scanEntity->getName() ?? '';
    }

    /**
     * @return string
     */
    public function getScanPhone(): string
    {
        return $this->scanEntity->getPhone() ?? '';
    }

    /**
     * @return string
     */
    public function getScanAddress(): string
    {
        return $this->scanEntity->getFullAddress() ?? '';
    }

    /**
     * @param string $apiName
     * @return string|null
     */
    public function getResName(string $apiName): ?string
    {
        return $this->getResEntity($apiName)->getName();
    }

    /**
     * @param string $apiName
     * @return string|null
     */
    public function getResPhone(string $apiName): ?string
    {
        return $this->getResEntity($apiName)->getPhone();
    }

    /**
     * @param string $apiName
     * @return string|null
     */
    public function getResAddress(string $apiName): ?string
    {
        return $this->getResEntity($apiName)->getFullAddress();
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isResLocationVerified(string $apiName): bool
    {
        return $this->getResEntity($apiName)->isLocationVerified();
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isNameListed(string $apiName): bool
    {
        return $this->getResName($apiName) !== null;
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isNameMatched(string $apiName): bool
    {
        return $this->isNameListed($apiName)
            && $this->getResName($apiName) === $this->getScanName();
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isPhoneListed(string $apiName): bool
    {
        return $this->getResPhone($apiName) !== null;
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isPhoneMatched(string $apiName): bool
    {
        return $this->isPhoneListed($apiName)
            && preg_replace('/\D/', '', $this->getResPhone($apiName) ?? '') === preg_replace('/\D/', '', $this->getScanPhone());
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isAddressListed(string $apiName): bool
    {
        return $this->getResAddress($apiName) !== null;
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isAddressMatched(string $apiName): bool
    {
        return $this->isAddressListed($apiName)
            && $this->getResAddress($apiName) === $this->getScanAddress();
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isListed(string $apiName): bool
    {
        return $this->isNameListed($apiName) || $this->isPhoneListed($apiName) || $this->isAddressListed($apiName);
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isMatchedAll(string $apiName): bool
    {
        return $this->isNameMatched($apiName) && $this->isPhoneMatched($apiName) && $this->isAddressMatched($apiName);
    }

    /**
     * @param string $apiName
     * @return bool
     */
    public function isMatchedOneOrMore(string $apiName): bool
    {
        return $this->isNameMatched($apiName) || $this->isPhoneMatched($apiName) || $this->isAddressMatched($apiName);
    }

    /**
     * @param string $apiName
     * @param bool $reCalc
     * @return int [0, 100]
     */
    public function getScore(string $apiName, bool $reCalc = false): int
    {
        if ($reCalc || !array_key_exists($apiName, $this->scores)) {
            $this->calcScore($apiName);
        }
        return $this->scores[$apiName];
    }

    /**
     * Calc score
     * @param string $apiName
     */
    protected function calcScore(string $apiName): void
    {
        if (!$this->isListed($apiName)) {
            $this->scores[$apiName] = 0;
            return;
        }
        if ($this->isMatchedAll($apiName)) {
            $this->scores[$apiName] = 100;
            return;
        }

        $score = 100;
        // name
        if (!$this->isNameListed($apiName)) {// missing
            $score -= 20; // discount 20 points from score
        } elseif (!$this->isNameMatched($apiName)) {// mismatch
            $score -= 10; // discount 10 points from score
        }
        // phone
        if (!$this->isPhoneListed($apiName)) {// missing
            $score -= 20; // discount 20 points from score
        } elseif (!$this->isPhoneMatched($apiName)) {// mismatch
            $score -= 10; // discount 10 points from score
        }
        // address
        if (!$this->isAddressListed($apiName)) {// missing
            $score -= 20; // discount 20 points from score
        } elseif (!$this->isAddressMatched($apiName)) {// mismatch
            $score -= 10; // discount 10 points from score
        }
        $this->scores[$apiName] = $score;
    }
}