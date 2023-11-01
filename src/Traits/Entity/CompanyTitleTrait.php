<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\Column;
use Maris\Symfony\Company\Entity\Business\Business;

/**
 * @extends Business
 */
trait CompanyTitleTrait
{
    /***
     * Название организации.
     * @var string
     */
//    #[Column(name: 'title')]
 //   protected ?string $title;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }






}