<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Unit\BankAccount\Payment;
use Maris\Symfony\Company\Entity\Unit\LegalForm;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Inn;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Kpp;
use Maris\Symfony\Company\Entity\Unit\LegalNumber\Ogrn;
use Maris\Symfony\Company\Service\QueryBuilderModifier;
use RuntimeException;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
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
        parent::__construct( $registry, Company::class );
        $this->modifierBuilder = $modifier;
    }

    /**
     * Сохраняет сущность.
     * @param Business $business
     * @param bool $isFlush
     * @return void
     */
    public function save( Business $business , bool $isFlush = false ):void
    {
        $this->getEntityManager()->persist( $business );
        if( $isFlush ) $this->getEntityManager()->flush();
    }

    /***
     * Удаляет сущность.
     * @param Business $business
     * @param bool $isFlush
     * @return void
     */
    public function remove( Business $business , bool $isFlush = false ):void
    {
        $this->getEntityManager()->remove( $business );
        if( $isFlush ) $this->getEntityManager()->flush();
    }

    /***
     * Получает организацию по ИНН + КПП.
     * Если ИНН не указан, то возвращается головной офис
     * @param string|Inn $inn
     * @param string|Kpp|null $kpp
     * @return Bank|null
     * @throws NonUniqueResultException
     */
    public function findByOneInn( string|Inn $inn, string|null|Kpp $kpp = null ):?Company
    {
        $builder = $this->createQueryBuilder('c')->andWhere('c.inn = :inn')
            ->setParameter('inn', ((is_string($inn)) ? new Inn($inn) : $inn)->getValue() );

        if(isset($kpp))
            $builder->andWhere('c.kpp = :kpp')
                ->setParameter('kpp', ((is_string($kpp)) ? new Kpp($kpp) : $kpp)->getValue() );
        else $builder->andWhere('c.parent_id = :parent')->setParameter('parent', null );

        return $builder->getQuery()->getOneOrNullResult();
    }

    /***
     * Получает список организаций по ИНН.
     * Технически это одна организация с филиалами.
     * @param string|Inn $inn
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Company[]
     */
    public function findByInn( string|Inn $inn , ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.inn = :inn')
            ->setParameter('inn', ((is_string($inn)) ? new Inn($inn) : $inn)->getValue());

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список организаций по КПП.
     * @param string|Kpp $kpp
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Company[]
     */
    public function findByKpp( string|Kpp $kpp , ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.kpp = :kpp')
            ->setParameter('kpp', ((is_string($kpp)) ? new Kpp($kpp) : $kpp)->getValue());

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список организаций по ОГРН.
     * @param string|Ogrn $ogrn
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return Company[]
     */
    public function findByOgrn( string|Ogrn $ogrn, ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.ogrn = :ogrn')
            ->setParameter('ogrn', ((is_string($ogrn)) ? new Ogrn($ogrn) : $ogrn)->getValue());

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /**
     * Получает организацию по ОГРН и КПП.
     * @throws NonUniqueResultException
     */
    public function findOneByOgrn(?string $ogrn, ?string $kpp = null ):?Company
    {
        $builder = $this->createQueryBuilder('c')->andWhere('c.ogrn = :ogrn')
            ->setParameter('ogrn', ((is_string($ogrn)) ? new Inn($ogrn) : $ogrn)->getValue() );

        if(isset($kpp))
            $builder->andWhere('c.kpp = :kpp')
                ->setParameter('kpp', ((is_string($kpp)) ? new Kpp($kpp) : $kpp)->getValue() );
        else $builder->andWhere('c.parent_id = :parent')->setParameter('parent', null );

        return $builder->getQuery()->getOneOrNullResult();
    }

    /***
     * Получает список фирм по названию.
     * @param string $title
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return array
     */
    public function findByTitle( string $title, ?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.title = :title')
            ->setParameter('title', $title );

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список фирм по организационно-правовой форме.
     * @param LegalForm $legalForm
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return array
     */
    public function findByLegalForm( LegalForm $legalForm ,?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.short_name = :short_name')
            ->andWhere('c.full_name = :full_name')
            ->setParameter('short_name', $legalForm->getShort() )
            ->setParameter('full_name', $legalForm->getFull() );

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список фирм по сокращенной организационно-правовой форме.
     * @param string $legalForm
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return array
     */
    public function findByShortLegalForm( string $legalForm ,?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.short_name = :short_name')
            ->setParameter('short_name', $legalForm );

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /***
     * Получает список фирм по полной организационно-правовой форме.
     * @param string $legalForm
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $orderBy
     * @return array
     */
    public function findByFullLegalForm( string $legalForm ,?int $limit = null, ?int $offset = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.full_name = :full_name')
            ->setParameter('full_name', $legalForm );

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

    /*public function findByPayment( Payment|string $payment, ?int $maxResult = null, ?array $orderBy = null ):array
    {
        $builder =  $this->createQueryBuilder('c')
            ->andWhere('c.payment_account = :payment_account')
            ->setParameter('full_name',  is_string($payment) ? $payment : $payment->getValue()  );

        $this->modifyBuilderOrderBy("c", $builder, $orderBy);
        $this->modifyBuilderMaxResults($builder,$maxResult);

        return $builder->getQuery()->getResult();
    }*/
    //public function findOneByPaymentAndBik():Company
    //public function findOneByPaymentAndBank():Company
    //public function findOneByPaymentAndBank():Company


    public function findLike(string $title , array $fields = [], ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        if(empty($fields))
            $fields = ["inn","ogrn","kpp","title"];

        $builder =  $this->createQueryBuilder('c');

        foreach ( $fields as $field )
            $builder->orWhere("c.$field LIKE :like_$field")
                ->setParameter("like_$field","%$title%");

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }

}