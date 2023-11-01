<?php

namespace Maris\Symfony\Company\Traits\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Person\Entity\Person;
use Maris\Symfony\Person\Traits\PersonAggregateNotNullTrait;

/***
 * @extends Business
 */
trait PersonTrait
{
    //use PersonAggregateNotNullTrait;
    /*#[OneToOne(targetEntity: Person::class,cascade: ['persist'])]
    #[JoinColumn(name: 'person_id')]
    protected Person $person;*/

    public function getPerson():Person
    {
        return $this->person;
    }

    public function setPerson( Person $person ):static
    {
        $this->person = $person;
        return $this;
    }
}