<?php

namespace Maris\Symfony\Company\Interfaces;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;

/***
 * Интерфейс для сущностей которые имеют ИНН.
 */
interface HaveKppInterface
{
    /***
     * Возвращает ИНН.
     * @return Kpp
     */
    public function getKpp():Kpp;
}