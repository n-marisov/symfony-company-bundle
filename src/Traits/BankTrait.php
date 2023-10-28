<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Maris\Symfony\Company\Entity\Business\Bank;

trait BankTrait
{
    /***
     * Банк в котором открыт счет.
     * @var Bank
     */
    #[ManyToOne(targetEntity: Bank::class,cascade: ['persist'])]
    #[JoinColumn(name: 'bank_id')]
    protected Bank $bank;
}