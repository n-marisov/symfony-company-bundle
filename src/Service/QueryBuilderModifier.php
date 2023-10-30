<?php

namespace Maris\Symfony\Company\Service;

use Doctrine\ORM\QueryBuilder;

/***
 * Сервис модифицирует объект QueryBuilder.
 */
class QueryBuilderModifier
{
    /***
     * Модифицирует QueryBuilder по параметру OrderBy.
     * Если $order === null сортировка не применяется.
     * @param string $alias
     * @param QueryBuilder $builder
     * @param array|null $orderBy
     * @return void
     */
    public function modifyOrderBy( string $alias, QueryBuilder $builder, ?array $orderBy ):void
    {
        if(is_null($orderBy)) return;
        $column = array_key_first($orderBy);

        if(is_numeric($column)) return;

        $builder->orderBy("$alias.$column", $orderBy[$column] );
    }

    /***
     * Модифицирует QueryBuilder по параметру MaxResults (максимальное кол-во результатов).
     * Если $maxResults === null или $maxResults < 1 ограничение не применяется.
     * @param QueryBuilder $builder
     * @param int|null $maxResults
     * @return void
     */
    public function modifyLimit( QueryBuilder $builder, ?int $maxResults ):void
    {
        if( !is_null($maxResults) && $maxResults > 0 )
            $builder->setMaxResults( $maxResults );
    }

    /***
     * Модифицирует QueryBuilder по параметру OFFSET (индекс начала выборки).
     * Если $maxResults === null или $maxResults < 1 ограничение не применяется.
     * @param QueryBuilder $builder
     * @param int|null $firstResults
     * @return void
     */
    public function modifyOffset( QueryBuilder $builder, ?int $firstResults ):void
    {
        if( !is_null($firstResults) && $firstResults > 0 )
            $builder->setFirstResult( $firstResults );
    }
}