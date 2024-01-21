<?php

namespace Tkuska\DynamicFormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\ArgumentInterface;
use Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class FormPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('form.extension')) {
            return;
        }

        $this->processAvailableFormTypes($container);
        $this->processFormTypeExtensions($container);
    }

    private function processAvailableFormTypes(ContainerBuilder $container): array
    {
        $servicesMap = [];
        $namespaces = ['Symfony\Component\Form\Extension\Core\Type' => true];

        // Builds an array with fully-qualified type class names as keys and service IDs as values
        foreach ($container->findTaggedServiceIds('form.type', true) as $serviceId => $tag) {
            // Add form type service to the service locator
            $serviceDefinition = $container->getDefinition($serviceId);
            $servicesMap[$formType = $serviceDefinition->getClass()] = new Reference($serviceId);
            $namespaces[substr($formType, 0, strrpos($formType, '\\'))] = true;
        }

        $typeCollectorDefinition = $container->getDefinition('dynamic-form.builder');
        $typeCollectorDefinition->setArgument(1, array_keys($namespaces));
        $typeCollectorDefinition->setArgument(2, array_keys($servicesMap));

        return $servicesMap;
    }

    private function processFormTypeExtensions(ContainerBuilder $container): array
    {
        $typeExtensions = [];
        $typeExtensionsClasses = [];
        foreach ($this->findAndSortTaggedServices('form.type_extension', $container) as $reference) {
            $serviceId = (string) $reference;
            $serviceDefinition = $container->getDefinition($serviceId);

            $tag = $serviceDefinition->getTag('form.type_extension');
            $typeExtensionClass = $container->getParameterBag()->resolveValue($serviceDefinition->getClass());

            if (isset($tag[0]['extended_type'])) {
                $typeExtensions[$tag[0]['extended_type']][] = new Reference($serviceId);
                $typeExtensionsClasses[] = $typeExtensionClass;
            } else {
                $extendsTypes = false;

                $typeExtensionsClasses[] = $typeExtensionClass;
                foreach ($typeExtensionClass::getExtendedTypes() as $extendedType) {
                    $typeExtensions[$extendedType][] = new Reference($serviceId);
                    $extendsTypes = true;
                }

                if (!$extendsTypes) {
                    throw new InvalidArgumentException(sprintf('The getExtendedTypes() method for service "%s" does not return any extended types.', $serviceId));
                }
            }
        }

        foreach ($typeExtensions as $extendedType => $extensions) {
            $typeExtensions[$extendedType] = new IteratorArgument($extensions);
        }

        $typeCollectorDefinition = $container->getDefinition('dynamic-form.builder');
        $typeCollectorDefinition->setArgument(3, array_keys($typeExtensionsClasses));

        return $typeExtensions;
    }
}
