<?php

namespace Maris\Symfony\Company\Entity\Embeddable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;

/*****
 * Модель Расчетный счет.
 * Служит для однозначной валидации Расчетного счета.
 * Если объект создан без ошибок значит Расчетный счет валидный.
 * Создание объекта не возможна без БИК.
 */
#[Embeddable]
class PaymentAccount implements Stringable
{
    #[Column( name: "payment_account", length: 20)]
    protected string $value;

    /**
     * @param string $value
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
    public function setValue(string $value, Bik $bik ): self
    {
        # Удаляем все кроме цифр
        $value = preg_replace("~\D+~","",$value);


        if(strlen($value) !== 20)
            throw new RuntimeException("Р/С может состоять только из 20 цифр");

        $bik_rs = substr((string) $bik, -3) . $value;
        $checksum = 0;
        foreach ([7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1] as $i => $k) {
            $checksum += $k * ((int) $bik_rs[$i] % 10);
        }
        if ($checksum % 10 !== 0)
            throw new \RuntimeException("Неправильное контрольное число.");

        $this->value = $value;
        return $this;
    }


    public function __toString()
    {
        return substr($this->value,0,5).".".
            substr($this->value,5,3).".".
            substr($this->value,8,1).".".
            substr($this->value,9,11);
    }
}