<?php

namespace Maris\Symfony\Company\Entity\Embeddable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;

/**
 * Модель Корреспондентский счет.
 * Служит для однозначной валидации Корреспондентского счета.
 * Если объект создан без ошибок значит Корреспондентский счет валидный.
 * Создание объекта не возможна без БИК.
 */
#[Embeddable]
class CorrespondentAccount implements Stringable
{
    #[Column( name: "correspondent_account", length: 20)]
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
            throw new RuntimeException("К/С может состоять только из 20 цифр");

        $bik_ks = '0' . substr((string) $bik, -5, 2) . $value;
        $check = 0;
        foreach ([7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1] as $i => $k) {
            $check += $k * ((int) $bik_ks[$i] % 10);
        }

        if($check % 10 !== 0)
            throw new RuntimeException("Неправильное контрольное число");

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