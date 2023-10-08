<?php

namespace Maris\Symfony\Company\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Person\Entity\Person;
use Maris\Symfony\Person\Traits\PersonAggregateNotNullTrait;

/**
 * Сущность индивидуального предпринимателя.
 */
#[Entity]
class Entrepreneur extends LegalBusiness implements PersonAggregateInterface
{
    use PersonAggregateNotNullTrait;
    #[OneToOne(targetEntity: Person::class,cascade: ['persist'])]
    #[JoinColumn(name: 'person_id')]
    protected Person $person;
}