<?php

namespace Maris\Symfony\Company\Entity\Business;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Company\Entity\Unit\LegalForm;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;
use Maris\Symfony\Company\Interfaces\HaveInnInterface;
use Maris\Symfony\Company\Interfaces\HaveLegalAddressInterface;
use Maris\Symfony\Company\Interfaces\HaveLegalFormInterface;
use Maris\Symfony\Company\Interfaces\HaveOgrnInterface;
use Maris\Symfony\Company\Interfaces\HaveWarehousesInterface;
use Maris\Symfony\Company\Repository\Business\EntrepreneurRepository;
use Maris\Symfony\Company\Traits\Entity\BankPaymentAccountsTrait;
use Maris\Symfony\Company\Traits\Entity\InnTrait;
use Maris\Symfony\Company\Traits\Entity\LegalAddressTrait;
use Maris\Symfony\Company\Traits\Entity\OgrnTrait;
use Maris\Symfony\Company\Traits\Entity\OpfTrait;
use Maris\Symfony\Company\Traits\Entity\PersonTrait;
use Maris\Symfony\Company\Traits\Entity\WarehouseTrait;
use Maris\Symfony\Person\Entity\Person;
use RuntimeException;

/**
 * Сущность индивидуального предпринимателя.
 *
 * 1. ИП не может существовать без объекта персоны.
 * 2. ИП не может существовать без ИНН.
 * 3. ИП не может существовать без ОГРН.
 * 4. ИП имеет организационно правовую форму, но она неизменяема.
 * 5. ИП может иметь склады загрузки/выгрузки.
 */
#[Entity(repositoryClass: EntrepreneurRepository::class)]
class Entrepreneur extends Business implements PersonAggregateInterface,HaveLegalFormInterface,HaveWarehousesInterface,HaveInnInterface,HaveOgrnInterface, HaveLegalAddressInterface
{
    /**
     * Правовая форма для всех объектов ИП.
     * @var LegalForm|null
     */
    protected static ?LegalForm $defaultLegalForm = null;

    /**
     * Добавляет ИНН, ОГРН правовую-форму и персону.
     */
    use InnTrait, OgrnTrait, OpfTrait, PersonTrait, WarehouseTrait, LegalAddressTrait;
    use BankPaymentAccountsTrait;


    /**
     * @param Person $person
     * @param string|Inn $inn
     * @param string|Ogrn $ogrn
     */
    public function __construct( Person $person , string|Inn $inn, string|Ogrn $ogrn )
    {
        $this->setPerson($person)->setInn($inn)->setOgrn($ogrn);

        $this->legalForm = self::$defaultLegalForm ??
            self::$defaultLegalForm = new LegalForm("Индивидуальный предприниматель","ИП");

        $this->bankPaymentAccounts = new ArrayCollection();

        if(!$this->ogrn->isOgrnIp())
            throw new RuntimeException("ИП присвоен ОГРН организации!");
    }

    /**
     * Запрещаем присвоение правовой формы.
     * @param LegalForm $legalForm
     * @return never
     * @throws RuntimeException
     */
    public function setLegalForm( LegalForm $legalForm ): never
    {
        throw new RuntimeException("Присвоение правовой формы предпринимателям запрещена!");
    }
}