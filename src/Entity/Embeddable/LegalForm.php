<?php

namespace Maris\Symfony\Company\Entity\Embeddable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

/***
 * Организационно-правовая форма.
 */
#[Embeddable]
class LegalForm
{
    /***
     * Сокращенное название организации.
     * @var string|null
     */
    #[Column(name: "short_name",nullable: true)]
    protected ?string $short;

    /***
     * Полное название организации.
     * @var string|null
     */
    #[Column(name: "full_name",nullable: true)]
    protected ?string $full;

    /**
     * @param string|null $short
     * @param string|null $full
     */
    public function __construct( ?string $full , ?string $short )
    {
        $this->short = $short;
        $this->full = $full;
    }

    /**
     * @return string|null
     */
    public function getShort(): ?string
    {
        return $this->short;
    }

    /**
     * @param string|null $short
     * @return $this
     */
    public function setShort(?string $short): self
    {
        $this->short = $short;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFull(): ?string
    {
        return $this->full;
    }

    /**
     * @param string|null $full
     * @return $this
     */
    public function setFull(?string $full): self
    {
        $this->full = $full;
        return $this;
    }

}