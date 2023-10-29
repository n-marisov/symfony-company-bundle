<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\Entity;

use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Company\Entity\Embeddable\Inn;
use Maris\Symfony\Company\Interfaces\HaveInnInterface;
use Maris\Symfony\Company\Interfaces\HaveWarehousesInterface;
use Maris\Symfony\Company\Traits\InnTrait;
use Maris\Symfony\Company\Traits\PersonTrait;
use Maris\Symfony\Company\Traits\WarehouseTrait;
use Maris\Symfony\Person\Entity\Person;

/**
 * Сущность самозанятого.
 * Имеет ИНН и данный персоны.
 *
 * 1. Самозанятый не может существовать без объекта персоны.
 * 2. Самозанятый не может существовать без ИНН.
 * 3. Самозанятый может иметь склады загрузки/выгрузки.
 */
//#[Entity]
class Employed extends Business implements PersonAggregateInterface, HaveWarehousesInterface,HaveInnInterface
{
    use InnTrait, PersonTrait, WarehouseTrait;

    public function __construct( Person $person, string|Inn $inn )
    {
        $this->setPerson( $person )->setInn( $inn );
    }
}