<?php

namespace Tkuska\DynamicFormBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Form\FormTypeInterface;

class TkuskaDynamicFormExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['TwigBundle'])) {
            $container->prependExtensionConfig('twig', [
                'form_themes' => ['@TkuskaDynamicForm/widget.html.twig'],
            ]);
        }

//        if ($this->isAssetMapperAvailable($container)) {
//            $container->prependExtensionConfig('framework', [
//                'asset_mapper' => [
//                    'paths' => [
//                        __DIR__.'/../../assets/dist' => '@tkuska/dynamic-form',
//                    ],
//                ],
//            ]);
//        }
    }

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


    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'].'/Resources/config/asset_mapper.php');
    }

}