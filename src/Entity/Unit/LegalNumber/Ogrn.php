<?php

namespace Maris\Symfony\Company\Entity\Unit\LegalNumber;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use RuntimeException;
use Stringable;
use function bcdiv;
use function bcmul;
use function bcsub;
use function substr;

/***
 * Модель ОРГН или ОГРНИП.
 * Служит для однозначной валидации ОРГН.
 * Если объект создан без ошибок значит ОРГН валидный.
 */
#[Embeddable]
class Ogrn implements Stringable
{
    #[Column(name: 'ogrn', length: '15',nullable: true)]
    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
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
        $value = preg_replace("~\D+~","",$value);

        if(!$this->validControlNumber($value))
            throw new RuntimeException("Неправильное контрольное число.");

        $this->value = $value;
        return $this;
    }

    protected function validControlNumber( string $ogrn ):bool
    {
        return match (strlen($ogrn)){
            13 => (int) $ogrn[12] ===  (int) substr(bcsub(substr($ogrn, 0, -1), bcmul(bcdiv(substr($ogrn, 0, -1), '11', 0), '11')), -1),
            15 => (int) $ogrn[14] ===  (int) substr(bcsub(substr($ogrn, 0, -1), bcmul(bcdiv(substr($ogrn, 0, -1), '13', 0), '13')), -1),
            default => throw new RuntimeException("ОГРН может состоять только из 13 или 15 цифр.")
        };
    }

    /**
     * Указывает что ОГРН принадлежит Индивидуальному Предпринимателю.
     * @return bool
     */
    public function isOgrnIp():bool
    {
        return strlen($this->value) === 15;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}