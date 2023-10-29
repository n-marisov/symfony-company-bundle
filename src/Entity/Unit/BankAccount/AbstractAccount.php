<?php

namespace Maris\Symfony\Company\Entity\Unit\BankAccount;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;
use RuntimeException;

/***
 * Абстрактный класс для банковских счетов.
 */
#[MappedSuperclass]
abstract class AbstractAccount
{
    protected string $value;
    /**
     * @param string $value
     * @param Bik $bik
     */
    public function __construct( string $value, Bik $bik )
    {
        $this->setValue( $value, $bik );
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @param Bik $bik
     * @return $this
     */
    public function setValue( string $value, Bik $bik ): self
    {
        # Удаляем все кроме цифр
        $value = preg_replace("~\D+~","",$value);


        if(strlen($value) !== 20)
            throw new RuntimeException("Банковский счет может состоять только из 20 цифр");

        if(!$this->checkSumValid( $this->getBikAccount( $bik, $value )))
            throw new RuntimeException("Неправильное контрольное число");

        $this->value = $value;
        return $this;
    }

    /***
     * Определяет схождение контрольной суммы.
     * @param string $bik_account
     * @return bool
     */
    protected function checkSumValid( string $bik_account ):bool
    {
        $check = 0;
        foreach ([7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1] as $i => $k)
            $check += $k * ((int) $bik_account[$i] % 10);
        return $check % 10 === 0;
    }

    /***
     * @param string $bik
     * @param string $account
     * @return string
     */
    abstract protected function getBikAccount( string $bik, string $account ):string;

    /***
     * Приводит счет к строке.
     * @return string
     */
    public function __toString()
    {
        return implode(".",[
            substr($this->value,0,5),
            substr($this->value,5,3),
            substr($this->value,8,1),
            substr($this->value,9,11)
        ]);
    }
}