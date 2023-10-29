<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Payment;

/***
 * Экспортируется в сущности которые имеют расчетный счет.
 */
trait PaymentAccountTrait
{
    /**
     * Расчетный счет
     * @var Payment
     */
    #[Embedded(class: Payment::class,columnPrefix: false)]
    protected Payment $paymentAccount;

    /**
     * @return Payment
     */
    public function getPaymentAccount(): Payment
    {
        return $this->paymentAccount;
    }

    /**
     * @param Payment $paymentAccount
     * @return $this
     */
    public function setPaymentAccount(Payment $paymentAccount): self
    {
        $this->paymentAccount = $paymentAccount;
        return $this;
    }


}