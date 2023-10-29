<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\Entity;
use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Company\Interfaces\HaveWarehousesInterface;
use Maris\Symfony\Company\Traits\PersonTrait;
use Maris\Symfony\Company\Traits\WarehouseTrait;
use Maris\Symfony\Person\Entity\Person;

/***
 * Сущность физического лица ведущее какую либо деятельность.
 * Для Грузоотправителей и Грузополучателей которые ведут бизнес как физ. лицо.
 * Не имеет ОПФ , филиалов.
 * Может иметь склады.
 *
 * 1. Физ.лицо не может существовать без объекта персоны.
 * 2. Физ.лицо может иметь склады загрузки/выгрузки.
 */
#[Entity]
class Physical extends Business implements PersonAggregateInterface,HaveWarehousesInterface
{
    /**
     * Добавляет возможность имения складов и объект персоны.
     */
    use PersonTrait, WarehouseTrait;

    /**
     * @param Person $person
     */
    public function __construct( Person $person )
    {
        $this->person = $person;
    }
}