<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * Реализует любую форму бизнеса
 */
#[MappedSuperclass]
abstract class LegalBusiness extends Business
{
    /***
     * ОГРН
     * @var string
     */
    #[Column(name: 'ogrn',length: '13')]
    protected string $ogrn;

    /**
     * @return string
     */
    public function getOgrn(): string
    {
        return $this->ogrn;
    }

    /**
     * @param string $ogrn
     * @return $this
     */
    public function setOgrn(string $ogrn): self
    {
        $this->ogrn = $ogrn;
        return $this;
    }
}