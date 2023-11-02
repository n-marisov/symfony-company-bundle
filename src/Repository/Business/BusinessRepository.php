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
     * @param array|null $fields Поля по которым идет поиск
     * @param array|null $types Типы организации среди которых идет поиск
     * @param int|null $limit Максимальное кол-во результатов
     * @param int|null $offset Отступ
     * @param array|null $orderBy Сортировка
     * @return list<Business>
     */
    public function findLike(string $value , ?array $fields = null, ?array $types = null, ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        $value =  "%".trim($value)."%";
        $aliases = [
            "inn" => "inn.value",
            "kpp" => "kpp.value",
            "ogrn" => "ogrn.value",
            "bik" => "bik.value",
            "title" => "title",
        ];

        if(empty($fields))
            $fields = ["inn","ogrn","kpp","bik","title"];


        $builder =  $this->createQueryBuilder('b');

        $whereFields = $builder->expr()->orX();
        foreach ( $fields as $field ){
            if(array_key_exists($field,$aliases)){
                $whereFields->add( $builder->expr()->like("b.{$aliases[$field]}",":$field") );
                $builder->setParameter( $field, $value );
                if($field == "title") {
                    $builder
                        ->leftJoin(Person::class,"p",Join::WITH,"b.person = p.id");
                    $whereFields
                        ->add($builder->expr()->like("p.surname",":$field"))
                        ->add($builder->expr()->like("p.firstname",":$field"))
                        ->add($builder->expr()->like("p.patronymic",":$field"));
                }
            }
        }
        $builder->andWhere($whereFields);

        /***
         * Ограничиваем поиск по типу данных.
         */
        if(!empty($types)){
            $typesWrite = $builder->expr()->orX();
            foreach ($types as $class){
                if(in_array($class,self::BUSINESS_TYPES))
                    $typesWrite->add($builder->expr()->isInstanceOf("b",$class));
            }
            $builder->andWhere($typesWrite);
        }

        /*$typesWrite = $builder->expr()->orX();

        foreach ($types as $type){
            if(in_array($type,self::BUSINESS_TYPES))
                $typesWrite->add("b  INSTANCE OF $type");
        }

        $builder->expr()->isInstanceOf();*/


        //$builder->andWhere($whereFields)->andWhere($typesWrite);

        $this->modifierBuilder->modifyOrderBy("b", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

        return $builder->getQuery()->getResult();
    }
}