<?php

namespace Maris\Symfony\Company\Formatter;

use Maris\Symfony\Company\Entity\Business\Bank;
use Maris\Symfony\Company\Entity\Business\Business;
use Maris\Symfony\Company\Entity\Business\Company;
use Maris\Symfony\Company\Entity\Business\Employed;
use Maris\Symfony\Company\Entity\Business\Entrepreneur;
use Maris\Symfony\Person\Entity\Person;
use RuntimeException;

/***
 * Форматирует название организации.
 */
class StringFormatterBusiness implements StringFormatterBusinessInterface
{

    public function formatFullType(Business $business): string
    {
        if (is_a($business, Employed::class))
            return $this->personFormat( $business->getPerson() );

        if( is_a($business, Entrepreneur::class) )
            return "{$business->getLegalForm()->getFull()} {$this->personFormat( $business->getPerson() )}";

        if( is_a($business, Bank::class) )
            return $business->getName();

        if( is_a($business, Company::class) )
            return "{$business->getLegalForm()->getFull()} {$business->getName()}";

        throw new RuntimeException("Неизвестная форма бизнеса.");

    }

    public function formatShortType( Business $business ): string
    {
        if (is_a($business, Employed::class))
            return $this->personFormat( $business->getPerson() );

        if( is_a($business, Entrepreneur::class) )
            return "{$business->getLegalForm()->getShort()} {$this->personFormat( $business->getPerson() )}";

        if( is_a($business, Bank::class) )
            return $business->getName();

        if( is_a($business, Company::class) )
            return "{$business->getLegalForm()->getShort()} {$business->getName()}";

        throw new RuntimeException("Неизвестная форма бизнеса.");
    }

    protected function personFormat( Person $person ):string
    {
        return "{$person->getSurname()} {$person->getFirstname()} {$person->getPatronymic()}";
    }
}