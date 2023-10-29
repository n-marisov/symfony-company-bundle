<?php

namespace Maris\Symfony\Company\Interfaces;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;

/***
 * Интерфейс для сущностей которые имеют ИНН.
 */
interface HaveOgrnInterface
{
    /***
     * Возвращает ИНН.
     * @return Ogrn
     */
    public function getOgrn():Ogrn;
}