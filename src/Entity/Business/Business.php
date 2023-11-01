<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Maris\Symfony\Address\Entity\Address;
use Maris\Symfony\Company\Entity\BankPaymentAccount;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Correspondent;
use Maris\Symfony\Company\Entity\Unit\LegalForm;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;
use Maris\Symfony\Company\Entity\Warehouse;
use Maris\Symfony\Company\Repository\Business\BusinessRepository;
use Maris\Symfony\Company\Traits\Entity\EntityIdentifierTrait;
use Maris\Symfony\Person\Entity\Person;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Реализует любую форму бизнеса.
 * Не является прямой сущностью.
 * Объединяет всех представителей бизнеса в одной таблице.
 * Является отражением "Юридического лица" (а не филиала).
 * Хранит в себе головной филиал.
 *
 * Сущность хранит в себе все ассоциации, а все потомки имеют аксесоры для доступа к ним
 */

#[Entity( repositoryClass: BusinessRepository::class )]
#[Table(name: 'business')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'business_type',type: 'string')]
#[DiscriminatorMap([
    "PHYSICAL" => Physical::class, # Физ.лицо
    "EMPLOYED" => Employed::class, # Самозанятый
    "ENTREPRENEUR" => Entrepreneur::class, # ИП
    "COMPANY" => Company::class, # Фирма
    "BANK" => Bank::class # Банк
    ])]

# Уникален для каждого филиала банка.
#[UniqueEntity(["bik"])]
#[UniqueConstraint(columns: ["bik"])]

# ИНН может быть один для всех филиалов организации при разных КПП
#[UniqueEntity(["inn","kpp"])]
#[UniqueConstraint(columns: ["inn","kpp"])]

# ОГРН может быть один для всех филиалов организации при разных КПП
#[UniqueEntity(["ogrn","kpp"])]
#[UniqueConstraint(columns: ["ogrn","kpp"])]

abstract class Business
{
    /**
     * Идентификатор.
     * @var int|null
     */
    #[Id,GeneratedValue]
    #[Column(options: ['unsigned'=>true])]
    private ?int $id = null;
    /***
     * ИНН
     * @var Inn|null
     */
    #[Embedded(class: Inn::class,columnPrefix: false)]
    protected ?Inn $inn = null;

    /***
     * ОГРН
     * @var Ogrn|null
     */
    #[Embedded(class: Ogrn::class,columnPrefix: false)]
    protected ?Ogrn $ogrn = null;

    /**
     * КПП.
     * @var Kpp|null
     */
    #[Embedded(class: Kpp::class,columnPrefix: false)]
    protected ?Kpp $kpp = null;

    /***
     * БИК
     * @var Bik|null
     */
    #[Embedded(class: Bik::class,columnPrefix: false)]
    protected ?Bik $bik = null;

    /***
     * Организационно-правовая форма.
     * @var LegalForm|null
     */
    #[Embedded(class: LegalForm::class,columnPrefix: "legal_form_")]
    protected ?LegalForm $legalForm = null;

    /***
     * Название организации.
     * @var string|null
     */
    #[Column(name: 'title')]
    protected ?string $title = null;

    /***
     * Для Физических лиц, Самозанятых и ИП данные персоны, для Организаций данные руководителя.
     * @var Person|null
     */
    #[OneToOne(targetEntity: Person::class,cascade: ['persist'])]
    #[JoinColumn(name: 'person_id')]
    protected ?Person $person = null;

    /***
     * Адрес регистрации (Юридический адрес);
     * @var Address|null
     */
    #[ManyToOne(targetEntity: Address::class,cascade: ['persist'])]
    #[JoinColumn(name: 'legal_address')]
    protected ?Address $legalAddress = null;

    /***
     * Корреспондентский счет.
     * @var Correspondent|null
     */
    #[Embedded(class: Correspondent::class,columnPrefix: false)]
    protected ?Correspondent $correspondent = null;

    /***
     * Список банковских счетов.
     * @var Collection<BankPaymentAccount>
     */
    #[OneToMany(mappedBy: 'business', targetEntity: BankPaymentAccount::class, cascade: ['persist'])]
    protected Collection $bankPaymentAccounts;

    /***
     * Банковский счет по умолчанию.
     * @var BankPaymentAccount|null
     */
    #[ManyToOne(targetEntity: BankPaymentAccount::class,cascade: ['persist'])]
    #[JoinColumn(name: 'default_payment_account', unique: true, nullable: true)]
    protected ?BankPaymentAccount $defaultPaymentAccount = null;

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
     * Возвращает идентификатор сущности.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}