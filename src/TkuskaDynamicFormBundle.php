<?php

namespace Tkuska\DynamicFormBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tkuska\DynamicFormBundle\DependencyInjection\FormPass;

class TkuskaDynamicFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
