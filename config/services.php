<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Tkuska\DynamicFormBundle\Form\FormFieldType;
use Tkuska\DynamicFormBundle\FormBuilder\Builder;
use Symfony\Component\Form\Extension\Core\Type as BaseType;

return static function (ContainerConfigurator $container) {

    $services = $container->services();
    $services->set('dynamic-form.builder', Builder::class)
        ->args([
            service('form.registry'),
            [], //populated by TkuskaDynamicFormExtension
            [], //populated by TkuskaDynamicFormExtension
            [], //populated by TkuskaDynamicFormExtension
        ]);

    $services->set('dynamic-form.type.field-type', FormFieldType::class)
        ->args([service('dynamic-form.builder')])
        ->tag('form.type');

};
