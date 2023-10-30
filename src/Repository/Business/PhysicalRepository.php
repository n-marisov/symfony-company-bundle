<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maris\Symfony\Company\Entity\Business\Physical;

/**
 * @extends ServiceEntityRepository<Physical>
 *
 * @method Physical|null find($id, $lockMode = null, $lockVersion = null)
 * @method Physical|null findOneBy(array $criteria, array $orderBy = null)
 * @method Physical[]    findAll()
 * @method Physical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhysicalRepository extends BusinessRepository
{
    protected const ENTITY_CLASS = Physical::class;
}