<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Tkuska\DynamicFormBundle\Form\FormFieldType;
use Tkuska\DynamicFormBundle\FormBuilder\Builder;
use Symfony\Component\Form\Extension\Core\Type as BaseType;

return static function (ContainerConfigurator $container) {

    $defaultTypes = [
        'textType' => BaseType\TextType::class,
        'choiceType' =>BaseType\ChoiceType::class,
        'numberType' =>BaseType\NumberType::class,
        'dateIntervalType' => BaseType\DateIntervalType::class,
        'moneyType' => BaseType\MoneyType::class,
        'timeType' =>BaseType\TimeType::class,
        'checkboxType' =>BaseType\CheckboxType::class,
        'colorType' =>BaseType\ColorType::class,
        'dateTimeType' =>BaseType\DateTimeType::class,
        'telType' =>BaseType\TelType::class,
        'emailType' =>BaseType\EmailType::class,
        'countryType' =>BaseType\CountryType::class,
        'currencyType' =>BaseType\CurrencyType::class,
        'fileType' =>BaseType\FileType::class,
        'integerType' =>BaseType\IntegerType::class
    ];
    $container->parameters()
        ->set('dynamic-form.types', $defaultTypes)
    ;

    $services = $container->services();
    $services->set(Builder::class)
        ->args([service('form.factory')]);

    $services->set('dynamic-form.type.field-type', FormFieldType::class)
        ->args([service(Builder::class)])
        ->tag('form.type');

};
