<?php

namespace Maris\Symfony\Company\Interfaces;

use Maris\Symfony\Address\Entity\Address;

/***
 * Для сущностей, что имеют юридический адрес.
 */
interface HaveLegalAddressInterface
{
    /**
     * Возвращает юридический адрес.
     * @return Address
     */
    public function getLegalAddress():Address;
}