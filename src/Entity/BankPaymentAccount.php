<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Payment;
use Maris\Symfony\Company\Traits\EntityIdentifierTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/***
 * Счет в банке (Р/С) (реквизиты для оплаты).
 * Неизменяемый объект.
 */

//У разных банков возможны одинаковые номера счетов.
//#[UniqueConstraint(columns: ["payment_account"])]
#[Entity(readOnly: true)]
#[UniqueEntity(["payment_account","bank_id"])]
#[Table(name: 'bank_accounts')]
class BankPaymentAccount
{
    use EntityIdentifierTrait;

    /***
     * Банк в котором открыт счет.
     * @var Bank
     */
    #[ManyToOne(targetEntity: Bank::class,cascade: ['persist'])]
    #[JoinColumn(name: 'bank_id')]
    protected Bank $bank;

    /**
     * Расчетный счет
     * @var Payment
     */
    #[Embedded(class: Payment::class,columnPrefix: false)]
    protected Payment $paymentAccount;

    /***
     * Владелец расчетного счета.
     * Расчетный счет может быть только у организации или ИП.
     * @var Entrepreneur|Company
     */
    #[ManyToOne(targetEntity: Business::class,cascade: ['persist'])]
    protected Entrepreneur|Company $business;

    /**
     * @param Company|Entrepreneur $business
     * @param Bank $bank
     * @param Payment|string $payment
     */
    public function __construct( Entrepreneur|Company $business, Bank $bank, Payment|string $payment )
    {
        $this->business = $business;
        $this->bank = $bank;
        $this->paymentAccount = (is_string($payment))? new Payment( $payment, $bank->getBik() ) : $payment;
    }


    /**
     * @return Company|Entrepreneur
     */
    public function getBusiness(): Entrepreneur|Company
    {
        return $this->business;
    }

    /**
     * @return Bank
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }

    /**
     * @return Payment
     */
    public function getPaymentAccount(): Payment
    {
        return $this->paymentAccount;
    }
}