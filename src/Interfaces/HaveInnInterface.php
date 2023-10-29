<?php

namespace Maris\Symfony\Company\Interfaces;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;

/***
 * Интерфейс для сущностей которые имеют ИНН.
 */
interface HaveInnInterface
{
    /***
     * Возвращает ИНН.
     * @return Inn
     */
    public function getInn():Inn;
}