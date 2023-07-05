<?php

namespace Maris\Symfony\Company\Entity;

use DateTimeInterface;

/**
 * Регистрационные данные компании
 */
class RegistrationData
{
    /**
     * ИНН компании
     * @var string|null
     */
    protected ?string $inn = null;

    /**
     * ОГРН компании
     * @var string|null
     */
    protected ?string $ogrn = null;

    /**
     * КПП компании
     * @var string|null
     */
    protected ?string $kpp = null;

    /**
     * Код ОКПО
     * @var string|null
     */
    protected ?string $okpo = null;

    /**
     * Код ОКАТО
     * @var string|null
     */
    protected ?string $okato = null;

    /**
     * Код ОКТМО
     * @var string|null
     */
    protected ?string $oktmo = null;

    /**
     * Код ОКОГУ
     * @var string|null
     */
    protected ?string $okogu = null;

    /**
     * Код ОКФС
     * @var string|null
     */
    protected ?string $okfs = null;

    /**
     * Основной код ОКВЕД
     * @var string|null
     */
    protected ?string $okved = null;

    /*****
     * Дата регистрации организации
     * @var DateTimeInterface|null
     */
    protected ?DateTimeInterface $date = null;

    /**
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }

    /**
     * @param string|null $inn
     * @return $this
     */
    public function setInn(?string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOgrn(): ?string
    {
        return $this->ogrn;
    }

    /**
     * @param string|null $ogrn
     * @return $this
     */
    public function setOgrn(?string $ogrn): self
    {
        $this->ogrn = $ogrn;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKpp(): ?string
    {
        return $this->kpp;
    }

    /**
     * @param string|null $kpp
     * @return $this
     */
    public function setKpp(?string $kpp): self
    {
        $this->kpp = $kpp;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOkpo(): ?string
    {
        return $this->okpo;
    }

    /**
     * @param string|null $okpo
     * @return $this
     */
    public function setOkpo(?string $okpo): self
    {
        $this->okpo = $okpo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOkato(): ?string
    {
        return $this->okato;
    }

    /**
     * @param string|null $okato
     * @return $this
     */
    public function setOkato(?string $okato): self
    {
        $this->okato = $okato;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOktmo(): ?string
    {
        return $this->oktmo;
    }

    /**
     * @param string|null $oktmo
     * @return $this
     */
    public function setOktmo(?string $oktmo): self
    {
        $this->oktmo = $oktmo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOkogu(): ?string
    {
        return $this->okogu;
    }

    /**
     * @param string|null $okogu
     * @return $this
     */
    public function setOkogu(?string $okogu): self
    {
        $this->okogu = $okogu;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOkfs(): ?string
    {
        return $this->okfs;
    }

    /**
     * @param string|null $okfs
     * @return $this
     */
    public function setOkfs(?string $okfs): self
    {
        $this->okfs = $okfs;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOkved(): ?string
    {
        return $this->okved;
    }

    /**
     * @param string|null $okved
     * @return $this
     */
    public function setOkved(?string $okved): self
    {
        $this->okved = $okved;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface|null $date
     * @return $this
     */
    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }


}