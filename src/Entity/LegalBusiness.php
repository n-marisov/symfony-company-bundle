<?php

namespace Maris\Symfony\Company\Entity;

/**
 * Реализует любую форму бизнеса
 */
abstract class LegalBusiness extends Business
{
    /***
     * ОГРН
     * @var int
     */
    protected int $ogrn;

    /**
     * @return int
     */
    public function getOgrn(): int
    {
        return $this->ogrn;
    }

    /**
     * @param int $ogrn
     * @return $this
     */
    public function setOgrn(int $ogrn): self
    {
        $this->ogrn = $ogrn;
        return $this;
    }
}