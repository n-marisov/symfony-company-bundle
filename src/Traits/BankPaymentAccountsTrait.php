<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Maris\Symfony\Company\Entity\BankPaymentAccount;

/***
 * Экспортируется в сущности которые имеют банковские счета.
 */
trait BankPaymentAccountsTrait
{
    /***
     * Список банковских счетов.
     * @var Collection<BankPaymentAccount>
     */
    #[OneToMany(mappedBy: 'business', targetEntity: BankPaymentAccount::class, cascade: ['persist'])]
    protected Collection $bankPaymentAccounts;

    /**
     * @return Collection<BankPaymentAccount>
     */
    public function getBankPaymentAccounts(): Collection
    {
        return $this->bankPaymentAccounts;
    }

    /**
     * @param Collection<BankPaymentAccount> $bankPaymentAccounts
     * @return $this
     */
    public function setBankPaymentAccounts(Collection $bankPaymentAccounts): self
    {
        $this->bankPaymentAccounts = $bankPaymentAccounts;
        return $this;
    }


}