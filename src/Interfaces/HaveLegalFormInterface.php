<?php

namespace Maris\Symfony\Company\Interfaces;

use Maris\Symfony\Company\Entity\Embeddable\LegalForm;

/***
 * Реализует сущности которые имеют организационно-правовую форму.
 */
interface HaveLegalFormInterface
{
    /***
     * Возвращает организационно правовую форму.
     * @return LegalForm
     */
    public function getLegalForm():LegalForm;
}