<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Address\Entity\Address;
use Maris\Symfony\Address\Interfaces\AddressAggregateInterface;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;

/**
 * Склад.
 */
#[Entity]
#[Table(name: 'warehouses')]
class Warehouse implements AddressAggregateInterface
{
    use EntityIdentifierTrait;

    /***
     * Название склада.
     * @var string
     */
    #[Column]
    protected string $title;

    /***
     * Организация которой принадлежит склад.
     * @var Business
     */
    #[ManyToOne(targetEntity: Business::class,cascade: ['persist'])]
    #[JoinColumn(name: 'business_id')]
    protected Business $business;

    /***
     * Адрес склада.
     * @var Address
     */
    #[ManyToOne(targetEntity: Address::class,cascade: ['persist'])]
    #[JoinColumn(name: 'address_id')]
    protected Address $address;

    /**
     * @return Business
     */
    public function getBusiness(): Business
    {
        return $this->business;
    }

    /**
     * @param Business $business
     * @return $this
     */
    public function setBusiness(Business $business): self
    {
        $this->business = $business;
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }



}