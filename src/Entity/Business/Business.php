<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Maris\Symfony\Company\Repository\Business\BusinessRepository;
use Maris\Symfony\Company\Traits\Entity\EntityIdentifierTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Реализует любую форму бизнеса.
 * Не является прямой сущностью.
 * Объединяет всех представителей бизнеса в одной таблице.
 * Является отражением "Юридического лица" (а не филиала).
 * Хранит в себе головной филиал.
 */

#[Entity( repositoryClass: BusinessRepository::class )]
#[Table(name: 'business')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'business_type',type: 'string')]
#[DiscriminatorMap([
    "PHYSICAL" => Physical::class, # Физ.лицо
    "EMPLOYED" => Employed::class, # Самозанятый
    "ENTREPRENEUR" => Entrepreneur::class, # ИП
    "COMPANY" => Company::class, # Фирма
    "BANK" => Bank::class # Банк
    ])]

# Уникален для каждого филиала банка.
#[UniqueEntity(["bik"])]
#[UniqueConstraint(columns: ["bik"])]

# ИНН может быть один для всех филиалов организации при разных КПП
#[UniqueEntity(["inn","kpp"])]
#[UniqueConstraint(columns: ["inn","kpp"])]

# ОГРН может быть один для всех филиалов организации при разных КПП
#[UniqueEntity(["ogrn","kpp"])]
#[UniqueConstraint(columns: ["ogrn","kpp"])]

abstract class Business{ use EntityIdentifierTrait; }