<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Physical;
use Maris\Symfony\Company\Service\QueryBuilderModifier;

/**
 * @extends ServiceEntityRepository<Physical>
 *
 * @method Physical|null find($id, $lockMode = null, $lockVersion = null)
 * @method Physical|null findOneBy(array $criteria, array $orderBy = null)
 * @method Physical[]    findAll()
 * @method Physical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhysicalRepository extends ServiceEntityRepository
{
    /**
     * Родительский репозиторий.
     * @var BusinessRepository
     */
    protected BusinessRepository $parent;

    /***
     * Сервис модифицирующий QueryBuilder
     * @var QueryBuilderModifier
     */
    protected QueryBuilderModifier $modifier;

    public function __construct( ManagerRegistry $registry, BusinessRepository $businessRepository,QueryBuilderModifier $modifier )
    {
        parent::__construct( $registry , Physical::class );
        $this->parent = $businessRepository;
        $this->modifier = $modifier;
    }

    /**
     * Сохраняет сущность.
     * @param Physical $physical
     * @param bool $isFlush
     * @return void
     */
    public function save( Physical $physical , bool $isFlush = false ):void
    {
        $this->parent->save( $physical, $isFlush );
    }

    /***
     * Удаляет сущность.
     * @param Physical $physical
     * @param bool $isFlush
     * @return void
     */
    public function remove( Physical $physical , bool $isFlush = false ):void
    {
        $this->parent->remove( $physical, $isFlush);
    }
    /***
     * Ищет физическое лицо по неполному параметру.
     * @param string $value Строка для поиска
     * @param array|null $fields Поля по которым идет поиск
     * @param int|null $limit Максимальное кол-во результатов
     * @param int|null $offset Отступ
     * @param array|null $orderBy Сортировка
     * @return list<Business>
     */
    public function findLike( string $value , ?array $fields = null, ?int $limit = null, ?int $offset = null, ?array $orderBy = null):array
    {
        return $this->parent->findLike( $value, $fields, [Physical::class], $limit, $offset, $orderBy );
    }

}