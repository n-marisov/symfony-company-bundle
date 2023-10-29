<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Correspondent;

/**
 * Экспортируется в сущности которые могут иметь Корреспондентский счет.
 */
trait CorrespondentTrait
{
    /***
     * Корреспондентский счет.
     * @var Correspondent
     */
    #[Embedded(class: Correspondent::class,columnPrefix: false)]
    protected Correspondent $correspondent;

    /**
     * @return Correspondent
     */
    public function getCorrespondent(): Correspondent
    {
        return $this->correspondent;
    }

    /**
     * @param Correspondent $correspondent
     * @return $this
     */
    public function setCorrespondent(Correspondent $correspondent): static
    {
        $this->correspondent = $correspondent;
        return $this;
    }


}