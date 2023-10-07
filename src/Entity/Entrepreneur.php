<?php

namespace Maris\Symfony\Company\Entity;

use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Person\Traits\PersonAggregateNotNullTrait;

/**
 * Сущность индивидуального предпринимателя.
 */
class Entrepreneur extends LegalBusiness implements PersonAggregateInterface
{
    use PersonAggregateNotNullTrait;
}