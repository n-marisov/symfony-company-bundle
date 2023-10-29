<?php

namespace Maris\Symfony\Company\Traits;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Maris\Symfony\Company\Entity\BankPaymentAccount;

/***
 * Экспортируется в сущности которые имеют Банковский счет.
 */
trait BankAccountsTrait
{
    /***
     * Банковский счет по умолчанию.
     * @var BankPaymentAccount|null
     */
    #[OneToOne(targetEntity: BankPaymentAccount::class,cascade: ['persist','remove'])]
    #[JoinColumn( name: 'bank_account',nullable: true )]
    protected ?BankPaymentAccount $defaultBankAccount = null;

    /***
     * Список всех банковских счетов организации.
     * @var Collection<BankPaymentAccount>
     */
    ##[ManyToMany(targetEntity: BankAccount::class,cascade: ['persist','remove'])]
    ##[JoinTable(name: 'business_bank_account')]
    ##[JoinColumn(name:"business_id",referencedColumnName: 'id')]
    ##[InverseJoinColumn(name: 'bank_account_id')]
    protected Collection $bankAccounts;
}