<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Address\Entity\Address;

/**
 * Реализует любую форму бизнеса
 */
#[Entity]
#[Table(name: 'business')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'business_type',type: 'integer')]
#[DiscriminatorMap([SelfEmployed::class,Entrepreneur::class,Company::class])]
abstract class Business
{
    /***
     * Идентификатор.
     * @var int|null
     */
    #[Id,GeneratedValue]
    #[Column(options: ['unsigned'=>true])]
    protected ?int $id = null;

    /***
     * ИНН Юр.лица
     * @var string
     */
    #[Column(name: 'inn',length: '12')]
    protected string $inn;

    /**
     * Юр.адрес
     * @var Address
     */
    #[ManyToOne(targetEntity: Address::class,cascade: ['persist'])]
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