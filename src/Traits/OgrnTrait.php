<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;

/***
 * Трейт импортируется во все сущности, что имеют ОГРН.
 */
trait OgrnTrait
{
    /***
     * ОГРН
     * @var Ogrn
     */
    #[Embedded(class: Ogrn::class,columnPrefix: false)]
    protected Ogrn $ogrn;

    /**
     * @return Ogrn
     */
    public function getOgrn(): Ogrn
    {
        return $this->ogrn;
    }

    /**
     * @param Ogrn|string $ogrn
     * @return $this
     */
    public function setOgrn(Ogrn|string $ogrn): static
    {
        $this->ogrn = is_string($ogrn) ? new Ogrn($ogrn) : $ogrn;
        return $this;
    }




}