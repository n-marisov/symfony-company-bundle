<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;

/**
 * Реализует любую форму бизнеса.
 * Не является прямой сущностью.
 * Объединяет всех представителей бизнеса в одной таблице.
 */
#[Entity]
#[Table(name: 'business',uniqueConstraints: [
    new UniqueConstraint(name:'bik_index',columns: ['bik'], fields: ['bik'])
] )]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'business_type',type: 'integer')]
#[DiscriminatorMap([Physical::class, Employed::class, Entrepreneur::class,Company::class, Bank::class ])]
abstract class Business
{
   use EntityIdentifierTrait;
}