<?php

namespace Maris\Symfony\Company\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

/**
 * Сущность юридического лица
 */
#[Entity]
class Company extends LegalBusiness
{
    /***
     * Организационно-правовая форма.
     * @var string
     */
    #[Column(name: 'form')]
    protected string $form;

    /***
     * Название организации.
     * @var string
     */
    #[Column(name: 'company_name')]
    protected string $name;

    /**
     * КПП Организации.
     * @var numeric-string
     */
    #[Column(name: 'kpp',length: '9')]
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