<?php

namespace Maris\Symfony\Company\Entity\Business;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Maris\Symfony\Company\Entity\Unit\LegalForm;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;
use Maris\Symfony\Company\Interfaces\HaveBranchesInterface;
use Maris\Symfony\Company\Interfaces\HaveInnInterface;
use Maris\Symfony\Company\Interfaces\HaveKppInterface;
use Maris\Symfony\Company\Interfaces\HaveLegalAddressInterface;
use Maris\Symfony\Company\Interfaces\HaveLegalFormInterface;
use Maris\Symfony\Company\Interfaces\HaveOgrnInterface;
use Maris\Symfony\Company\Interfaces\HaveWarehousesInterface;
use Maris\Symfony\Company\Repository\Business\CompanyRepository;
use Maris\Symfony\Company\Traits\Entity\BankPaymentAccountsTrait;
use Maris\Symfony\Company\Traits\Entity\CompanyTitleTrait;
use Maris\Symfony\Company\Traits\Entity\InnTrait;
use Maris\Symfony\Company\Traits\Entity\KppTrait;
use Maris\Symfony\Company\Traits\Entity\LegalAddressTrait;
use Maris\Symfony\Company\Traits\Entity\OgrnTrait;
use Maris\Symfony\Company\Traits\Entity\OpfTrait;
use Maris\Symfony\Company\Traits\Entity\WarehouseTrait;
use RuntimeException;

/**
 * Сущность компании(организации).
 * 1. Компания не может существовать без названия.
 * 2. Компания не может существовать без организационно-правовой формы.
 * 3. Компания не может существовать без ИНН.
 * 4. Компания не может существовать без ОГРН.
 * 5. Компания не может существовать без КПП.
 * 6. Компания может иметь склады загрузки/выгрузки.
 * 7. Компания может иметь филиалы.
 */
#[Entity(repositoryClass: CompanyRepository::class)]
class Company extends Business implements HaveLegalFormInterface, HaveWarehousesInterface, HaveBranchesInterface,HaveInnInterface,HaveKppInterface,HaveOgrnInterface, HaveLegalAddressInterface
{
    use InnTrait, OgrnTrait, KppTrait, OpfTrait, CompanyTitleTrait, WarehouseTrait,LegalAddressTrait;

    /***
     * Добавляет возможность хранения банковских счетов.
     */
    use BankPaymentAccountsTrait;

    /**
     * Родительский филиал.
     * Если null, то текущая организация головной офис.
     * @var Company |null
     */
    #[ManyToOne(targetEntity: self::class, cascade: ["persist"], inversedBy: 'branches')]
    #[JoinColumn(name: 'parent_id')]
    protected ?Company $mainBranch = null;

    /***
     * Список дочерних филиалов.
     * @var Collection<static>
     */
    #[OneToMany(mappedBy: 'mainBranch', targetEntity: self::class, cascade: ['persist'])]
    protected Collection $branches;

    /***
     * @param LegalForm $legalForm
     * @param string $title
     * @param string|Inn $inn
     * @param string|Ogrn $ogrn
     * @param string|Kpp $kpp
     */
    public function __construct(LegalForm $legalForm,string $title,string|Inn $inn, string|Ogrn $ogrn, string|Kpp $kpp)
    {
        $this->branches = new ArrayCollection();
        $this->warehouses = new ArrayCollection();
        $this->setLegalForm($legalForm)->setName($title)->setInn($inn)->setOgrn($ogrn)->setKpp($kpp);

        if($this->ogrn->isOgrnIp())
            throw new RuntimeException("Компании присвоен ОГРНИП!");
    }


    /**
     * @return Collection
     */
    public function getBranches(): Collection
    {
        return $this->branches;
    }

    /**
     * @param Collection $branches
     * @return $this
     */
    public function setBranches(Collection $branches): self
    {
        $this->branches = $branches;
        return $this;
    }

    /***
     * Указывает что текущий филиал головной.
     * @return bool
     */
    public function isMainBranch():bool
    {
        return is_null($this->mainBranch);
    }

    /***
     * @return $this|null
     */
    public function getMainBranch(): ?static
    {
       return $this->mainBranch;
    }

    /**
     * @param Company $mainBranch
     * @return $this
     */
    public function setMainBranch( Company $mainBranch ):static
    {
        $this->mainBranch = $mainBranch;
        return $this;
    }
}