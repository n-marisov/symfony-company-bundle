<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Maris\Symfony\Company\Entity\BankPaymentAccount;
use Maris\Symfony\Company\Entity\Business\Bank;
use RuntimeException;

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

    /***
     * Банковский счет по умолчанию.
     * @var BankPaymentAccount|null
     */
    protected ?BankPaymentAccount $defaultPaymentAccount = null;

    /**
     * @return Collection<BankPaymentAccount>
     */
    public function getBankPaymentAccounts(): Collection
    {
        return $this->bankPaymentAccounts;
    }

    /***
     * Добавляет платежный счет в коллекцию.
     * Если в коллекции всего один счет, то он устанавливается по умолчанию.
     * @param string $payment
     * @param Bank $bank
     * @param bool $isDefault Устанавливает текущий счет по умолчанию.
     * @return $this
     */
    public function addBankPaymentAccount( string $payment, Bank $bank, bool $isDefault = false ):static
    {
        $this->bankPaymentAccounts->add( new BankPaymentAccount( $this, $bank, $payment ) );
        if( $this->bankPaymentAccounts->count() === 1 || $isDefault )
            $this->defaultPaymentAccount = $this->bankPaymentAccounts->first();

        return $this;
    }

    /***
     * Удаляет расчетный счет по номеру счета и банку или по объекту Р/С (BankPaymentAccount).
     * Если передан BankPaymentAccount::class банк можно не указывать.
     * @return $this
     */
    protected function removeBankPaymentAccount( string|BankPaymentAccount $payment , ?Bank $bank = null):static
    {
        if( is_string($payment) )
            if(isset($bank)){
                $payment = new BankPaymentAccount( $this, $bank, $payment );
            } else throw new RuntimeException("Р/С Указан как строка, укажите банк.");

        /***
         * Получаем элемент который нужно удалить.
         */
        $first = $this->bankPaymentAccounts->findFirst(function ( BankPaymentAccount $item ) use ($payment){
            return $payment->getBank()->getBik() === $item->getBank()->getBik() &&
                $payment->getPaymentAccount()->getValue() === $item->getPaymentAccount()->getValue();
        });

        if(isset($first))
            $this->bankPaymentAccounts->removeElement( $first );

        if($first === $this->defaultPaymentAccount)
            $this->defaultPaymentAccount = $this->bankPaymentAccounts->first() ?? null;

        return $this;
    }

    /***
     * Удаляет все значения которые соответствуют номеру расчетного счета.
     * @param string $payment
     * @return $this
     */
    protected function removeAllBankPaymentAccounts( string $payment ):static
    {
        $payment = trim($payment);
        $elements = $this->bankPaymentAccounts->filter(function ( BankPaymentAccount $item ) use ($payment){
            $element = $item->getPaymentAccount();
            return $element->getValue() === $payment || (string) $element === $payment;
        });

        foreach ($elements as $element)
            $this->bankPaymentAccounts->removeElement( $element );

        if(!$this->bankPaymentAccounts->contains($this->defaultPaymentAccount))
            $this->defaultPaymentAccount = $this->bankPaymentAccounts->first() ?? null;

        return $this;
    }


}