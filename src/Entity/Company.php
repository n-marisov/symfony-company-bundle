<?php

namespace Maris\Symfony\Company\Entity;


/**
 * Сущность юридического лица
 */
class Company extends LegalBusiness
{
    /***
     * Организационно-правовая форма.
     * @var string
     */
    protected string $form;

    /***
     * Название организации.
     * @var string
     */
    protected string $name;

    /**
     * КПП Организации.
     * @var numeric-string
     */
    protected string $kpp;

    /**
     * @return string
     */
    public function getForm(): string
    {
        return $this->form;
    }

    /**
     * @param string $form
     * @return $this
     */
    public function setForm(string $form): self
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getKpp(): string
    {
        return $this->kpp;
    }

    /**
     * @param string $kpp
     * @return $this
     */
    public function setKpp(string $kpp): self
    {
        $this->kpp = $kpp;
        return $this;
    }


}