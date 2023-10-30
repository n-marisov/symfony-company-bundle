<?php

namespace Maris\Symfony\Company\Entity\Unit\LegalNumber;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;

/***
 * Модель БИК.
 * Служит для однозначной валидации БИК.
 * Если объект создан без ошибок значит БИК валидный.
 */
#[Embeddable]
class Bik implements Stringable
{

    #[Column( name: "bik", length: 9)]
    protected string $value;

    /**
     * @param string $value
     * @throws RuntimeException
     */
    public function __construct( string $value )
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

        if(strlen($value) !== 9)
            throw new RuntimeException("БИК может состоять только из 9 цифр.");

        $this->value = $value;
        return $this;
    }




    public function __toString(): string
    {
        return $this->value;
    }
}