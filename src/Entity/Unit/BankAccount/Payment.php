<?php

namespace Maris\Symfony\Company\Entity\Unit\BankAccount;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;
use RuntimeException;
use Stringable;

/*****
 * Модель Расчетный счет.
 * Служит для однозначной валидации Расчетного счета.
 * Если объект создан без ошибок значит Расчетный счет валидный.
 * Создание объекта не возможна без БИК.
 */
#[Embeddable]
class Payment extends AbstractAccount implements Stringable
{
    #[Column( name: "payment_account", length: 20)]
    protected string $value;

    protected function getBikAccount(string $bik, string $account): string
    {
        return substr( $bik, -3 ) . $account;
    }
}