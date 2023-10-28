<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Embeddable\CorrespondentAccount;

/**
 * Экспортируется в сущности которые могут иметь Корреспондентский счет.
 */
trait CorrespondentTrait
{
    /***
     * Корреспондентский счет.
     * @var CorrespondentAccount
     */
    #[Embedded(class: CorrespondentAccount::class,columnPrefix: false)]
    protected CorrespondentAccount $correspondent;

    /**
     * @return CorrespondentAccount
     */
    public function getCorrespondent(): CorrespondentAccount
    {
        return $this->correspondent;
    }

    /**
     * @param CorrespondentAccount $correspondent
     * @return $this
     */
    public function setCorrespondent(CorrespondentAccount $correspondent): static
    {
        $this->correspondent = $correspondent;
        return $this;
    }


}