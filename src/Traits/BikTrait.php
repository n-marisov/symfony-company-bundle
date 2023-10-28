<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Embeddable\Bik;

trait BikTrait
{
    /***
     * БИК Банка.
     * @var Bik
     */
    #[Embedded(class: Bik::class,columnPrefix: false)]
    protected Bik $bik;

    /**
     * @return Bik
     */
    public function getBik(): Bik
    {
        return $this->bik;
    }

    /**
     * @param Bik $bik
     * @return $this
     */
    public function setBik(Bik $bik): static
    {
        $this->bik = $bik;
        return $this;
    }

}