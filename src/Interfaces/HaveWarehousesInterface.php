<?php

namespace Maris\Symfony\Company\Interfaces;

use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Company\Entity\Warehouse;

/***
 * Интерфейс сущности которая имеет склады.
 */
interface HaveWarehousesInterface
{
    /***
     * Возвращает главный склад.
     * @return Warehouse|null
     */
    public function getDefaultWarehouse():?Warehouse;

    /**
     * Возвращает список всех складов.
     * @return Collection<Warehouse>
     */
    public function getWarehouses():Collection;
}