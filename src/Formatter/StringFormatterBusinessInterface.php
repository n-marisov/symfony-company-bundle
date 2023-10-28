<?php

namespace Maris\Symfony\Company\Formatter;

use Maris\Symfony\Company\Entity\Business\Business;

interface StringFormatterBusinessInterface
{
    /**
     * Форматирует название организации с полным названием правовой формы.
     * @param Business $business
     * @return string
     */
    public function formatFullType( Business $business ):string;

    /**
     * Форматирует название организации с сокращенным названием правовой формы.
     * @param Business $business
     * @return string
     */
    public function formatShortType(  Business $business  ):string;
}