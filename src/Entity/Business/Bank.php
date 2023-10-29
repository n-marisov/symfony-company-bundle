<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Maris\Symfony\Company\Entity\Embeddable\Bik;
use Maris\Symfony\Company\Entity\Embeddable\CorrespondentAccount;
use Maris\Symfony\Company\Entity\Embeddable\Inn;
use Maris\Symfony\Company\Entity\Embeddable\Kpp;
use Maris\Symfony\Company\Interfaces\HaveBikInterface;
use Maris\Symfony\Company\Interfaces\HaveBranchesInterface;
use Maris\Symfony\Company\Interfaces\HaveInnInterface;
use Maris\Symfony\Company\Interfaces\HaveKppInterface;
use Maris\Symfony\Company\Interfaces\HaveLegalAddressInterface;
use Maris\Symfony\Company\Traits\BikTrait;
use Maris\Symfony\Company\Traits\CompanyTitleTrait;
use Maris\Symfony\Company\Traits\CorrespondentTrait;
use Maris\Symfony\Company\Traits\InnTrait;
use Maris\Symfony\Company\Traits\KppTrait;
use Maris\Symfony\Company\Traits\LegalAddressTrait;

/***
 * Сущность Банк.
 */
//#[Entity]
class Bank extends Business implements HaveBranchesInterface,HaveInnInterface,HaveKppInterface,HaveBikInterface,HaveLegalAddressInterface
{
    use InnTrait, KppTrait, BikTrait, CorrespondentTrait, CompanyTitleTrait,LegalAddressTrait;

    /**
     * Родительский филиал.
     * Если null, то текущая организация головной офис.
     * @var Bank |null
     */
    #[OneToMany(mappedBy: 'branches', targetEntity: self::class, cascade: ["persist"])]
    #[JoinColumn(name: 'parent_id')]
    protected ?Bank $mainBranch = null;

    /***
     * Список дочерних филиалов.
     * @var Collection<Company>
     */
    #[ManyToOne(targetEntity: self::class,cascade: ['persist'],inversedBy: 'parent')]
    protected Collection $branches;

    public function __construct( string $title , Inn|string $inn ,Kpp|string $kpp, Bik|string $bik, CorrespondentAccount $correspondent )
    {
        $this->branches = new ArrayCollection();
        $this->setName( $title )->setInn($inn)->setKpp($kpp)->setBik($bik)->setCorrespondent($correspondent);
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
     * @param Bank $mainBranch
     * @return $this
     */
    public function setMainBranch( Bank $mainBranch ):static
    {
        $this->mainBranch = $mainBranch;
        return $this;
    }
}