<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;

/**
 * Реализует любую форму бизнеса.
 * Не является прямой сущностью.
 * Объединяет всех представителей бизнеса в одной таблице.
 * Является отражением "Юридического лица" (а не филиала).
 */
#[Entity]
#[Table(name: 'business')]
#[InheritanceType('SINGLE_TABLE')]
/***
 * ИНН и ОГРН у филиалов одинаковы.
 */
#[UniqueConstraint(columns: ["inn"])]
#[UniqueConstraint(columns: ["ogrn"])]
#[UniqueConstraint(columns: ["kpp"])]
#[UniqueConstraint(columns: ["bik"])]
#[DiscriminatorColumn(name: 'business_type',type: 'string')]
#[DiscriminatorMap([
    "Физ.лицо" => Physical::class,
    "Самозанятый" => Employed::class,
    "ИП" => Entrepreneur::class,
    "Фирма" => Company::class,
    "Банк" => Bank::class
    ])]
abstract class Business
{
   use EntityIdentifierTrait;
}