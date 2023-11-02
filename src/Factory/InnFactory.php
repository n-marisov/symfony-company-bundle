<?php

namespace Maris\Symfony\Company\Factory;

use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/***
 * Фабрика для создания объектов ИНН.
 */
class InnFactory
{
    protected ReflectionClass $creator;

    protected ReflectionProperty $initializer;

    public function __construct()
    {
        $this->creator = new ReflectionClass(Inn::class);
        $this->initializer = $this->creator->getProperty("value");
    }


    /***
     * Создает объект из строки.
     * @param string $inn
     * @return Inn|null
     * @throws ReflectionException
     */
    public function create( string $inn ):?Inn
    {
        if(!$this->valid($inn))
            return null;

        $instance = $this->creator->newInstanceWithoutConstructor();
        $this->initializer->setValue( $instance, $inn );

        return $instance;
    }

    /***
     * Ищет ИНН в строке.
     * @param string $str
     * @return array
     * @throws ReflectionException
     */
    public function parse( string $str ):array
    {
        $result = [];
        $matches = [];
        preg_match_all("/\D(\d{10}|\d{12})\D/",$str,$matches );

        foreach ($matches[1] ?? [] as $item)
            if(!is_null($inn = $this->create( $item )))
                $result[] = $inn;

        return $result;
    }

    /***
     * Проверяет ИНН на валидность.
     * Строка должна состоять только из цифр.
     * @param string $inn
     * @return bool
     */
    public function valid( string $inn ):bool
    {
        return ctype_digit($inn) && match ( strlen($inn) ){
            10 => intval( $inn[9] ) === $this->checkDigit10($inn),
            12 => intval( $inn[10] ) === $this->checkDigit11($inn) &&
                  intval( $inn[11] ) === $this->checkDigit12($inn),
           default => false
        };
    }

    protected function checkDigit10( string $inn ):int
    {
        $sum = 0;
        foreach ([2, 4, 10, 3, 5, 9, 4, 6, 8] as $i => $weight)
            $sum += $weight * $inn[$i];
        return $sum % 11 % 10;
    }
    protected function checkDigit11( string $inn ):int
    {
        $sum = 0;
        foreach ([7, 2, 4, 10, 3, 5, 9, 4, 6, 8] as $i => $weight)
        {
            $sum += $weight * $inn[$i];
        }
        return $sum % 11 % 10;
    }
    protected function checkDigit12( string $inn ):int
    {
        $sum = 0;
        foreach ([3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8] as $i => $weight)
        {
            $sum += $weight * $inn[$i];
        }
        return $sum % 11 % 10;
    }
}