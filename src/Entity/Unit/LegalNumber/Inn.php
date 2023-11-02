<?php

namespace Maris\Symfony\Company\Entity\Unit\LegalNumber;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;

/**
 * Модель ИНН.
 * Сущность с закрытым конструктором, создается через фабрики.
 * Служит для однозначной валидации ИНН.
 * Если объект создан без ошибок значит ИНН валидный.
 */
#[Embeddable]
class Inn implements Stringable
{

 ///   private const CHECK_DIGIT_COEFFICIENTS_10 = [2, 4, 10, 3, 5, 9, 4, 6, 8];
//    private const CHECK_DIGIT_COEFFICIENTS_11 = [2, 4, 10, 3, 5, 9, 4, 6, 8];
 //   private const CHECK_DIGIT_COEFFICIENTS_12 = [2, 4, 10, 3, 5, 9, 4, 6, 8];

    /***
     * Значение ИНН хранится как строка.
     * @var string
     */
    #[Column( name: 'inn', length: '12', nullable: true )]
    public readonly string $value;

    private function __construct(){}


    /**
     * @param string $value
     * @throws RuntimeException
     */
   /* public function __construct( string $value )
    {
        $this->setValue( $value );
    }*/

    /**
     * @return string
     */
    /*public function getValue(): string
    {
        return $this->value;
    }*/

    /**
     * @param string $value
     * @return $this
     * @throws RuntimeException
     */
    /*public function setValue(string $value): self
    {
        # Удаляем все кроме цифр
        $value = preg_replace("~\D+~","",$value);

        if(!$this->checkDigitValid($value))
            throw new RuntimeException("Неправильное контрольное число.");

        $this->value = $value;
        return $this;
    }*/

    /***
     * Вычисляет контрольное число.
     * @param string $inn
     * @param array $coefficients
     * @return bool
     */
   /* protected function checkDigit( string $inn, array $coefficients ):bool
    {
        $n = 0;
        foreach ($coefficients as $i => $k)
            $n += $k * (int) $inn[$i];
        return $n % 11 % 10;
    }*/

    /***
     * Проверяет на соответствию контрольному числу
     * @param string $inn
     * @return bool
     */
   /* protected function checkDigitValid( string $inn ):bool
    {
        switch (strlen($inn)) {
            case 10:
                $n10 = $this->checkDigit($inn, self::CHECK_DIGIT_COEFFICIENTS_10);
                return $n10 == (int) $inn[9];
            case 12:
                $n11 = $this->checkDigit($inn, self::CHECK_DIGIT_COEFFICIENTS_11);
                $n12 = $this->checkDigit($inn, self::CHECK_DIGIT_COEFFICIENTS_12);
                dump($n11 ==  $inn[10]);
                dump($n12 ==  $inn[11]);
                return ($n11 == (int) $inn[10]) && ($n12 == (int) $inn[11]);
        }

        throw new RuntimeException("ИНН может состоять только из 10 или 12 цифр, передано: \"$inn\".");
    }*/

    /***
     * Приводит ИНН к строке.
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}