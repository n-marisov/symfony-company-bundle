<?php

namespace Maris\Symfony\Company\Entity;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Traits\Entity\EntityIdentifierTrait;

/***
 * Филиал Банка/Компании.
 */
#[Entity]
#[Table(name: 'business_branches')]
class Branch
{
    use EntityIdentifierTrait;

    /***
     * Организация которой принадлежит филиал.
     * @var Company|Bank
     */
    protected Company|Bank $business;
}