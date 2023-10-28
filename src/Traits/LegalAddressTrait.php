<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Maris\Symfony\Address\Entity\Address;

/**
 * Экспортируется в сущности которые имеют Юридический адрес.ы
 */
trait LegalAddressTrait
{
    #[ManyToOne(targetEntity: Address::class,cascade: ['persist'])]
    #[JoinColumn(name: 'legal_address')]
    protected Address $legalAddress;

    /**
     * @return Address
     */
    public function getLegalAddress(): Address
    {
        return $this->legalAddress;
    }

    /**
     * @param Address $legalAddress
     * @return $this
     */
    public function setLegalAddress(Address $legalAddress): self
    {
        $this->legalAddress = $legalAddress;
        return $this;
    }


}