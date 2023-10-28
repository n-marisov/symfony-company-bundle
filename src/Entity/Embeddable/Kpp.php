<?php

namespace Maris\Symfony\Company\Entity\Embeddable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;

/***
 * Модель КПП.
 * Служит для однозначной валидации КПП.
 * Если объект создан без ошибок значит КПП валидный.
 */
#[Embeddable]
class Kpp implements Stringable
{
    #[Column(name: 'kpp', length: '9')]
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

        if(strlen($value) !== 9)
            throw new RuntimeException("Длинна КПП должна составлять 9 знаков.");

        if(!preg_match("/^[0-9]{4}[0-9A-Z]{2}[0-9]{3}$/",$value))
            throw new RuntimeException("Неправильный формат КПП.");

        $this->value = $value;
        return $this;
    }


    public function __toString():string
    {
        return $this->value;
    }
}