<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Maris\Symfony\Person\Entity\Person;
use Maris\Symfony\Person\Traits\PersonAggregateNotNullTrait;

trait PersonTrait
{
    use PersonAggregateNotNullTrait;
    #[OneToOne(targetEntity: Person::class,cascade: ['persist'])]
    #[JoinColumn(name: 'person_id')]
    protected Person $person;
}