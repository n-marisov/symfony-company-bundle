<?php

namespace Maris\Symfony\Company\Interfaces;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;

/***
 * Интерфейс для сущностей которые имеют ИНН.
 */
interface HaveBikInterface
{
    /***
     * Возвращает ИНН.
     * @return Bik
     */
    public function getBik():Bik;
}