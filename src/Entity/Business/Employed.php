<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\Entity;
use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Interfaces\HaveInnInterface;
use Maris\Symfony\Company\Interfaces\HaveWarehousesInterface;
use Maris\Symfony\Company\Repository\Business\EmployedRepository;
use Maris\Symfony\Company\Traits\Entity\InnTrait;
use Maris\Symfony\Company\Traits\Entity\PersonTrait;
use Maris\Symfony\Company\Traits\Entity\WarehouseTrait;
use Maris\Symfony\Person\Entity\Person;

/**
 * Сущность самозанятого.
 * Имеет ИНН и данный персоны.
 *
 * 1. Самозанятый не может существовать без объекта персоны.
 * 2. Самозанятый не может существовать без ИНН.
 * 3. Самозанятый может иметь склады загрузки/выгрузки.
 */
#[Entity(repositoryClass: EmployedRepository::class)]
class Employed extends Business implements PersonAggregateInterface, HaveWarehousesInterface,HaveInnInterface
{
    use InnTrait, PersonTrait, WarehouseTrait;

    public function __construct( Person $person, string|Inn $inn )
    {
        $this->setPerson( $person )->setInn( $inn );
    }
}