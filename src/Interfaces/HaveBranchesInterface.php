<?php

namespace Maris\Symfony\Company\Interfaces;

use Doctrine\Common\Collections\Collection;

/***
 * Реализует сущности которые имеют филиалы.
 */
interface HaveBranchesInterface
{
    /***
     * Указывает что текущий филиал головной.
     * @return bool
     */
    public function isMainBranch():bool;

    /***
     * Возвращает головной филиал или null если текущий филиал головной.
     * @return $this|null
     */
    public function getMainBranch():?static;

    /***
     * Возвращает список филиалов.
     * @return Collection
     */
    public function getBranches():Collection;
}