<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Business\Employed;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;
use Maris\Symfony\Company\Entity\Business\Physical;
use Maris\Symfony\Company\Service\QueryBuilderModifier;
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

        $aliases = [
            "inn" => "inn.value",
            "kpp" => "kpp.value",
            "ogrn" => "ogrn.value",
            "title" => "title",
        ];

        if(empty($fields))
            $fields = ["inn","ogrn"];

        if(empty($types))
            $types = [ "PHYSICAL", "EMPLOYED", "ENTREPRENEUR", "COMPANY", "BANK" ];

        $builder =  $this->createQueryBuilder('c');

        $builder = new QueryBuilder( $this->getEntityManager() );
        $builder->select("f","s","i","c","b");
        $builder->from(Physical::class, "f");
        $builder->from(Employed::class, "s");
        $builder->from(Entrepreneur::class, "i");
        $builder->from(Company::class, "c");
        $builder->from(Bank::class, "b");


        $newFields = [];
        foreach ( $fields as $field )
            if(array_key_exists($field,$aliases))
                $newFields[$field] = $aliases[$field];
        $fields = $newFields;

        foreach ( $fields as $field => $fieldAddress ){
            if(is_null($builder->getParameter("like_$field")))
                $builder->setParameter("like_$field","%$value%");

            if(in_array($field,["inn","ogrn"])){
                $builder->orWhere("i.$fieldAddress LIKE :like_$field");
            }
        }


       // $this->modifierBuilder->modifyOrderBy("c", $builder, $orderBy);
        $this->modifierBuilder->modifyLimit( $builder, $limit );
        $this->modifierBuilder->modifyOffset($builder, $offset );

       //dump($builder->getQuery()->getSQL());

        return $builder->getQuery()->getResult();
    }
}