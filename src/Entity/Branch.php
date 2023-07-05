<?php

namespace Maris\Symfony\Company\Entity;

use Maris\Symfony\Address\Entity\Address;

/**
 * Филиал организации
 */
class Branch
{
    protected ?int $id;

    /**
     * Компания которой принадлежит филиал
     * @var Company
     */
    protected Company $company;

    /**
     * Адрес филиала
     * @var Address
     */
    protected Address $address;

    /**
     * Название филиала
     * @var string
     */
    protected string $name;
}