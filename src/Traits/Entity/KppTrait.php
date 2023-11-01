<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;

/***
 * @extends Business
 */
trait KppTrait
{
    /**
     * КПП Организации.
     * @var Kpp|null
     */
    #[Embedded(class: Kpp::class,columnPrefix: false)]
    protected ?Kpp $kpp = null;

    /**
     * @return Kpp
     */
    public function getKpp(): Kpp
    {
        return $this->kpp;
    }

    /**
     * @param Kpp $kpp
     * @return $this
     */
    public function setKpp(Kpp $kpp): static
    {
        $this->kpp = $kpp;
        return $this;
    }




}