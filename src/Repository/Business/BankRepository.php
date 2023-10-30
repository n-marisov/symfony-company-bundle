<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Maris\Symfony\Company\Entity\BankPaymentAccount;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Correspondent;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Payment;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Bik;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;
use Maris\Symfony\Company\Service\QueryBuilderModifier;
use RuntimeException;

/**
 * Репозиторий для банка.
 * @extends ServiceEntityRepository<Bank>
 *
 * @method Bank|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bank|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bank[]    findAll()
 * @method Bank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankRepository extends ServiceEntityRepository
{
    /***
     * Сервис модифицирующий QueryBuilder
     * @var QueryBuilderModifier
     */
    protected QueryBuilderModifier $modifierBuilder;

    /***
     * @param ManagerRegistry $registry
     * @param QueryBuilderModifier $modifier
     */
    public function __construct( ManagerRegistry $registry, QueryBuilderModifier $modifier )
    {
        parent::__construct( $registry, Bank::class );
        $this->modifierBuilder = $modifier;
    }

    /**
     * Сохраняет сущность.
     * @param Bank $business
     * @param bool $isFlush
     * @return void
     */
    public function save( Bank $business , bool $isFlush = false ):void
    {
        $this->getEntityManager()->persist( $business );
        if( $isFlush ) $this->getEntityManager()->flush();
    }

    /***
     * Удаляет сущность.
     * @param Bank $business
     * @param bool $isFlush
     * @return void
     */
    public function remove( Bank $business , bool $isFlush = false ):void
    {
        $this->getEntityManager()->remove( $business );
        if( $isFlush ) $this->getEntityManager()->flush();
    }

    /***
     * Получает банк по БИК.
     * @param string|Bik $bik
     * @return Bank|null
     * @throws NonUniqueResultException
     * @throws RuntimeException
     */
    public function findByOneBik( string|Bik $bik ):?Bank
    {
        return $this->createQueryBuilder('b')->andWhere('b.bik = :bik')
            ->setParameter('bik', ((is_string($bik)) ? new Bik($bik) : $bik)->getValue() )
            ->getQuery()->getOneOrNullResult();
    }

    /***
     * Получает банк по ИНН + КПП.
     * Если ИНН не указан, то возвращается головной офис
     * @param string|Inn $inn
     * @param string|Kpp|null $kpp
     * @return Bank|null
     * @throws NonUniqueResultException
     */
    public function findByOneInn( string|Inn $inn, string|null|Kpp $kpp = null ):?Bank
    {
        $builder = $this->createQueryBuilder('b')->andWhere('b.inn = :inn')
            ->setParameter('inn', ((is_string($inn)) ? new Inn($inn) : $inn)->getValue() );

        if(isset($kpp))
            $builder->andWhere('b.kpp = :kpp')
                ->setParameter('kpp', ((is_string($kpp)) ? new Kpp($kpp) : $kpp)->getValue() );
        else $builder->andWhere('b.parent_id = :parent')->setParameter('parent', null );

        return $builder->getQuery()->getOneOrNullResult();
    }

    /***
     * Получает список банков по ИНН.
     * Банк и филиалы.
     * @param string|Inn $inn
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Bank[]
     */
    public function findByInn(string|Inn $inn , ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder = $this->createQueryBuilder('b');
        $builder->andWhere('b.inn = :inn')
            ->setParameter('inn', ((is_string($inn)) ? new Inn($inn) : $inn)->getValue());

        $this->modifierBuilder->modifyOrderBy("b", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список банков по КПП.
     * @param string|Kpp $kpp
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Bank[]
     */
    public function findByKpp( string|Kpp $kpp , ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('b')
            ->andWhere('b.kpp = :kpp')
            ->andWhere("b")
            ->setParameter('kpp', ((is_string($kpp)) ? new Kpp($kpp) : $kpp)->getValue());

        $this->modifierBuilder->modifyOrderBy("b", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список банков по Кор. Счету.
     * @param Correspondent|string $correspondent
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Bank[]
     */
    public function findByCorrespondent( Correspondent|string $correspondent, ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('b')
            ->andWhere('b.correspondent = :correspondent')
            ->setParameter(
                'correspondent',
                (is_string($correspondent)) ? $correspondent : $correspondent->getValue()
            );

        $this->modifierBuilder->modifyOrderBy("b", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * ????????? Проверить
     * Получает список банков по Кор. Счету.
     * @param Payment|string $payment
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Bank[]
     */
    public function findByPayment( Payment|string $payment, ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('b', 'a')
            ->from(Bank::class, 'b')
            ->leftJoin(BankPaymentAccount::class, 'a', Join::WITH, "a.bank_id = b.id")
            ->where('a.payment_account = :payment')
            ->setParameter('payment', (is_string($payment) ? $payment : $payment->getValue() ));

        $this->modifierBuilder->modifyOrderBy("b", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * ????????? Проверить
     * Получает Банк по Корреспондентскому счету и Расчетному счету.
     * @param Payment|string $payment
     * @param Correspondent|string $correspondent
     * @return Bank|null
     * @throws NonUniqueResultException
     */
    public function findOneByPaymentAndCorrespondent( Payment|string $payment, Correspondent|string $correspondent ):?Bank
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('b', 'a')
            ->from(Bank::class, 'b')
            ->leftJoin(BankPaymentAccount::class, 'a', Join::WITH, "a.bank_id = b.id")
            ->andWhere( 'a.payment_account = :payment')
            ->andWhere("b.correspondent_account = :correspondent")
            ->setParameter('payment', (is_string($payment) ? $payment : $payment->getValue() ))
            ->setParameter('correspondent', (is_string($correspondent) ? $correspondent : $correspondent->getValue() ));


        return $builder->getQuery()->getOneOrNullResult();
    }
}