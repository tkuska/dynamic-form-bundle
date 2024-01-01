<?php

namespace Tkuska\DynamicFormBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Form\FormTypeInterface;

class TkuskaDynamicFormExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');

        $defaultTypes = $container->getParameter('dynamic-form.types');

//        foreach($defaultTypes as $type){
//            if(!$container->has($type)){
//                throw new ServiceNotFoundException($type);
//            }
//
//            $definition = $container->findDefinition($type)
//                ->addTag('form.dynamic-type');
//        }
    }

}