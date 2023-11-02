<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Business\Employed;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;
use Maris\Symfony\Company\Entity\Business\Physical;
use Maris\Symfony\Company\Service\QueryBuilderModifier;
use Maris\Symfony\Person\Entity\Person;
use TypeError;

/**
 * Репозиторий для всех представителей бизнеса (объектов Business::class).
 * @extends ServiceEntityRepository<Business>
 *
 * @method Business|null find($id, $lockMode = null, $lockVersion = null)
 * @method Business|null findOneBy(array $criteria, array $orderBy = null)
 * @method Business[]    findAll()
 * @method Business[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessRepository extends ServiceEntityRepository
{
    /****
     * Типы данных с которыми работает репозиторий.
     */
    protected const BUSINESS_TYPES = [
        Physical::class, Employed::class,Entrepreneur::class,Company::class,Bank::class
    ];


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
        parent::__construct( $registry, Business::class );
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
     * Ищет организацию.
     * @param string $value Строка для поиска
     * @param array $fields Поля по которым идет поиск
     * @param array $types Типы организации среди которых идет поиск
     * @param int|null $limit Максимальное кол-во результатов
     * @param int|null $offset Отступ
     * @param array|null $orderBy Сортировка
     * @return list<Business>
     */
    public function findLike(string $value , array $fields = [], array $types = [], ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        $value =  "%".trim($value)."%";
        $aliases = [
            "inn" => "inn.value",
            "kpp" => "kpp.value",
            "ogrn" => "ogrn.value",
            "bik" => "bik.value",
            "title" => "title",
        ];

        $builder =  $this->createQueryBuilder('b');

        $whereFields = $builder->expr()->orX();
        foreach ( $fields as $field ){
            if(array_key_exists($field,$aliases)){
                $whereFields->add( $builder->expr()->like("b.{$aliases[$field]}",":$field") );
                $builder->setParameter( $field, $value );
            }
            if($fields == "title")
            {
                $builder
                ->leftJoin(Person::class,"p",Join::WITH,"b.person = p.id");
                $whereFields
                    ->add($builder->expr()->like("b.person.surname",":$field"))
                    ->add($builder->expr()->like("b.person.firstname",":$field"))
                    ->add($builder->expr()->like("b.person.patronymic",":$field"));
            }
        }

        $typesWrite = $builder->expr()->orX();

        foreach ($types as $type){
            if(in_array($type,self::BUSINESS_TYPES))
                $typesWrite->add("b  INSTANCE OF $type");
        }


        $builder->andWhere($whereFields)->andWhere($typesWrite);

        $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }
}