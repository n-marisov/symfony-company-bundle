<?php

namespace Maris\Symfony\Company\Entity\Unit\BankAccount;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;
use RuntimeException;
use Stringable;

/**
 * Модель Корреспондентский счет.
 * Служит для однозначной валидации Корреспондентского счета.
 * Если объект создан без ошибок значит Корреспондентский счет валидный.
 * Создание объекта не возможна без БИК.
 */
#[Embeddable]
class Correspondent extends AbstractAccount implements Stringable
{
    #[Column( name: "correspondent_account", length: 20)]
    protected string $value;


    protected function getBikAccount(string $bik, string $account): string
    {
        return '0' . substr( $bik, -5, 2) . $account;
    }
}