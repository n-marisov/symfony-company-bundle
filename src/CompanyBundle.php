<?php

namespace Maris\Symfony\Company;

use Maris\Symfony\Company\DependencyInjection\CompanyExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CompanyBundle extends AbstractBundle{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CompanyExtension();
    }

}