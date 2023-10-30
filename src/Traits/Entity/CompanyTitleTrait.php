<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\Column;

trait CompanyTitleTrait
{
    /***
     * Название организации.
     * @var string
     */
    #[Column(name: 'title')]
    protected string $name;

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




}