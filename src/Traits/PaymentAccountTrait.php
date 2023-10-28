<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Embeddable\PaymentAccount;

/***
 * Экспортируется в сущности которые имеют расчетный счет.
 */
trait PaymentAccountTrait
{
    /**
     * Расчетный счет
     * @var PaymentAccount
     */
    #[Embedded(class: PaymentAccount::class,columnPrefix: false)]
    protected PaymentAccount $paymentAccount;

    /**
     * @return PaymentAccount
     */
    public function getPaymentAccount(): PaymentAccount
    {
        return $this->paymentAccount;
    }

    /**
     * @param PaymentAccount $paymentAccount
     * @return $this
     */
    public function setPaymentAccount(PaymentAccount $paymentAccount): self
    {
        $this->paymentAccount = $paymentAccount;
        return $this;
    }


}