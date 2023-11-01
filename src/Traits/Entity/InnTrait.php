<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;

/***
 * @extends Business
 * Трейт импортируется во все сущности, что имеют ИНН.
 */
trait InnTrait
{
    /***
     * ИНН
     * @var Inn
     */
  //  #[Embedded(class: Inn::class,columnPrefix: false)]
  //  protected Inn $inn;

    /**
     * @return Inn
     */
    public function getInn(): Inn
    {
        return $this->inn;
    }

    /**
     * @param Inn|string $inn
     * @return $this
     */
    public function setInn( Inn|string $inn ): static
    {
        $this->inn = is_string($inn) ? new Inn($inn) : $inn;;
        return $this;
    }



}