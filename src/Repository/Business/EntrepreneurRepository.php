<?php

namespace Maris\Symfony\Company\Repository\Business;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;

/**
 * @extends ServiceEntityRepository<Entrepreneur>
 *
 * @method Entrepreneur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrepreneur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrepreneur[]    findAll()
 * @method Entrepreneur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepreneurRepository extends BusinessRepository
{
    protected const ENTITY_CLASS = Entrepreneur::class;
}