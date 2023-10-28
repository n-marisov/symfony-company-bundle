<?php

namespace Maris\Symfony\Company\Entity\Embeddable;

use Doctrine\ORM\Mapping\Column;
use RuntimeException;
use Stringable;

class Snils implements Stringable
{
    #[Column( name: "snils", length: 11, unique: true)]
    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue( $value );
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
     * @return $this
     */
    public function setValue(string $value): self
    {

        # Удаляем все кроме цифр
        $value = preg_replace("~\D+~","",$value);

        if(strlen($value) !== 11)
            throw new RuntimeException("СНИЛС может состоять только из 11 цифр.");

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $value[$i] * (9 - $i);
        }

        $check_digit = ($sum < 100) ? $sum : $sum % 101;
        if ($check_digit === 100)
            $check_digit = 0;

        if ($check_digit !== (int) substr($value, -2))
            throw new RuntimeException("Неправильное контрольное число.");

        $this->value = $value;
        return $this;
    }

    /**
     * Форматирует СНИЛС как в документе.
     * @return string
     */
    public function __toString():string
    {
        return substr($this->value,0,3)."-"
            .substr($this->value,3,3)."-"
            .substr($this->value,6,3)." "
            .substr($this->value,9,2);
    }
}