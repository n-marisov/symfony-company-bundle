<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;
use Maris\Symfony\Company\Traits\BankTrait;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;
use Maris\Symfony\Company\Traits\PaymentAccountTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/***
 * Счет в банке (Р/С) (реквизиты для оплаты)
 */
#[Entity]
//У разных банков возможны одинаковые номера счетов.
//#[UniqueConstraint(columns: ["payment_account"])]
#[UniqueEntity(["payment_account","bank_id"])]
#[Table(name: 'bank_accounts')]
class BankPaymentAccount
{
    use EntityIdentifierTrait, BankTrait, PaymentAccountTrait;

    /***
     * Владелец расчетного счета.
     * Расчетный счет может быть только у организации или ИП.
     * @var Entrepreneur|Company
     */
    #[ManyToOne(targetEntity: Business::class,cascade: ['persist'])]
    protected Entrepreneur|Company $business;

    /**
     * @return Company|Entrepreneur
     */
    public function getBusiness(): Entrepreneur|Company
    {
        return $this->business;
    }

    /**
     * @param Company|Entrepreneur $business
     * @return $this
     */
    public function setBusiness(Entrepreneur|Company $business): self
    {
        $this->business = $business;
        return $this;
    }


}