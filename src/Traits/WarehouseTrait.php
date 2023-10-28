<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Maris\Symfony\Company\Entity\Warehouse;

trait WarehouseTrait
{
    /***
     * Главный склад.
     * @var Warehouse|null
     */
    #[ManyToOne(targetEntity: Warehouse::class,cascade: ["persist"])]
    #[JoinColumn(name: 'warehouse_id')]
    protected ?Warehouse $defaultWarehouse = null;

    /***
     * Список складов.
     * @var Collection
     */
    #[OneToMany(mappedBy: 'business', targetEntity: Warehouse::class, cascade: ['persist'])]
    protected Collection $warehouses;

    /**
     * @return Warehouse|null
     */
    public function getDefaultWarehouse(): ?Warehouse
    {
        return $this->defaultWarehouse;
    }

    /**
     * @param Warehouse|null $defaultWarehouse
     * @return $this
     */
    public function setDefaultWarehouse(?Warehouse $defaultWarehouse): self
    {
        $this->defaultWarehouse = $defaultWarehouse;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getWarehouses(): Collection
    {
        return $this->warehouses;
    }

    /**
     * @param Collection $warehouses
     * @return $this
     */
    public function setWarehouses(Collection $warehouses): self
    {
        $this->warehouses = $warehouses;
        return $this;
    }





}