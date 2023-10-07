<?php

namespace Maris\Symfony\Company\Entity;

use Maris\Symfony\Address\Interfaces\AddressAggregateInterface;
use Maris\Symfony\Address\Traits\AddressAggregateNotNullTrait;

/***
 * Филиал организации.
 */
class Branch implements AddressAggregateInterface
{
    /**
     * Реализация AddressAggregateInterface::class
     */
    use AddressAggregateNotNullTrait;

    /**
     * Идентификатор.
     * @var int|null
     */
    protected ?int $id;

    /***
     * Название филиала.
     * @var string
     */
    protected string $name;

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


}