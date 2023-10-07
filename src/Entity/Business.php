<?php

namespace Maris\Symfony\Company\Entity;

use Maris\Symfony\Address\Entity\Address;

/**
 * Реализует любую форму бизнеса
 */
abstract class Business
{
    /***
     * Идентификатор.
     * @var int|null
     */
    protected ?int $id = null;

    /***
     * ИНН Юр.лица
     * @var string
     */
    protected string $inn;

    /**
     * Юр.адрес
     * @var Address
     */
    protected Address $address;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     * @return $this
     */
    public function setInn(string $inn): self
    {
        $this->inn = $inn;
        return $this;
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


}