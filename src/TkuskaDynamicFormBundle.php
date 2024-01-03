<?php

namespace Tkuska\DynamicFormBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tkuska\DynamicFormBundle\DependencyInjection\TkuskaDynamicFormExtension;

class TkuskaDynamicFormBundle extends Bundle
{

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
