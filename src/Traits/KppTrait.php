<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;

trait KppTrait
{
    /**
     * КПП Организации.
     * @var Kpp
     */
    #[Embedded(class: Kpp::class,columnPrefix: false)]
    protected Kpp $kpp;

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