<?php

namespace Maris\Symfony\Company\Interfaces;
use Maris\Symfony\Company\Entity\Embeddable\Inn;
use Maris\Symfony\Company\Entity\Embeddable\Kpp;

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