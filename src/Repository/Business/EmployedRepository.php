<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maris\Symfony\Company\Entity\Business\Employed;

/**
 * @extends ServiceEntityRepository<Employed>
 *
 * @method Employed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employed[]    findAll()
 * @method Employed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployedRepository extends BusinessRepository
{
    protected const ENTITY_CLASS = Employed::class;
}