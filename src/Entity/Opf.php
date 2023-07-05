<?php

namespace Maris\Symfony\Company\Entity;
/**
 * Организационно-правовая форма
 */
class Opf
{
    /**
     * Полное название организационно-правовой формы
     * @var string
     */
    protected string $full;

    /**
     * Сокращенное название организационно-правовой формы
     * @var string
     */
    protected string $short;

    /**
     * @param string $full
     * @param string $short
     */
    public function __construct( string $short, string $full )
    {
        $this->full = $full;
        $this->short = $short;
    }

    /**
     * @return string
     */
    public function getFull(): string
    {
        return $this->full;
    }

    /**
     * @param string $full
     * @return $this
     */
    public function setFull(string $full): self
    {
        $this->full = $full;
        return $this;
    }

    /**
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @param string $short
     * @return $this
     */
    public function setShort(string $short): self
    {
        $this->short = $short;
        return $this;
    }



}