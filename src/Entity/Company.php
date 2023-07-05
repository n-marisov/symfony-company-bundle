<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Address\Entity\Address;
use Maris\Symfony\Person\Entity\Person;

/**
 * Сущность юридического лица
 */
class Company
{
    /**
     * ID сущности
     * @var int|null
     */
    protected ?int $id;

    /**
     * Юридический адрес организации
     * @var Address
     */
    protected Address $address;

    /**
     * Организационно-правовая форма
     * @var Opf
     */
    protected Opf $opf;

    /**
     * Название организации
     * @var string
     */
    protected string $name;

    /**
     * Регистрационные данные компании
     * @var RegistrationData
     */
    protected RegistrationData $registrationData;


    /**
     * Филиалы организации
     * @var Collection<Branch>
     */
    protected Collection $branches;

    /**
     * Персона предпринимателя для ИП,
     * генеральный директор для Юридического лица.
     * @var Person
     */
    protected Person $management;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function setAddress(Address $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Opf
     */
    public function getOpf(): Opf
    {
        return $this->opf;
    }

    /**
     * @param Opf $opf
     * @return $this
     */
    public function setOpf(Opf $opf): self
    {
        $this->opf = $opf;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return RegistrationData
     */
    public function getRegistrationData(): RegistrationData
    {
        return $this->registrationData;
    }

    /**
     * @param RegistrationData $registrationData
     * @return $this
     */
    public function setRegistrationData(RegistrationData $registrationData): self
    {
        $this->registrationData = $registrationData;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getBranches(): Collection
    {
        return $this->branches;
    }

    /**
     * @param Collection $branches
     * @return $this
     */
    public function setBranches(Collection $branches): self
    {
        $this->branches = $branches;
        return $this;
    }

    /**
     * @return Person
     */
    public function getManagement(): Person
    {
        return $this->management;
    }

    /**
     * @param Person $management
     * @return $this
     */
    public function setManagement(Person $management): self
    {
        $this->management = $management;
        return $this;
    }



}