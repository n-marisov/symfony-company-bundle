<?php

namespace Maris\Symfony\Company\Entity;

use Maris\interfaces\Person\Model\PersonAggregateInterface;
use Maris\Symfony\Person\Traits\PersonAggregateNotNullTrait;

/**
 * Модель самозанятый.
 */
class SelfEmployed extends Business implements PersonAggregateInterface
{
   use PersonAggregateNotNullTrait;
}