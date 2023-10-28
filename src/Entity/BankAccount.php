<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Traits\BankTrait;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;
use Maris\Symfony\Company\Traits\PaymentAccountTrait;

/***
 * Счет в банке (реквизиты для оплаты)ы
 */
#[Entity]
#[Table(name: 'bank_accounts')]
class BankAccount
{
    use EntityIdentifierTrait, BankTrait, PaymentAccountTrait;
}