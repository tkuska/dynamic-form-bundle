<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Tkuska\DynamicFormBundle\FormBuilder\Builder;
use Symfony\Component\Form\Extension\Core\Type as BaseType;

return static function (ContainerConfigurator $container) {

    $defaultTypes = [
        BaseType\TextType::class,
        BaseType\ChoiceType::class,
        BaseType\NumberType::class,
        BaseType\DateIntervalType::class,
        BaseType\MoneyType::class,
        BaseType\TimeType::class,
        BaseType\CheckboxType::class,
        BaseType\ColorType::class,
        BaseType\DateTimeType::class,
        BaseType\TelType::class,
        BaseType\EmailType::class,
        BaseType\CountryType::class,
        BaseType\CurrencyType::class,
        BaseType\FileType::class,
        BaseType\IntegerType::class
    ];
    $container->parameters()
        ->set('dynamic-form.types', $defaultTypes)
    ;


    $services = $container->services();

    foreach ($defaultTypes as $defaultType){
        $services->set($defaultType)
            ->tag('form.dynamic-type');
    }
    $services->set(Builder::class)
        ->args([tagged_iterator('form.dynamic-type')])
        ->autowire();


};
