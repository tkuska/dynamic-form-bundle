<?php

namespace Tkuska\DynamicFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tkuska\DynamicFormBundle\Entity\Form;
use Tkuska\DynamicFormBundle\Entity\FormField;

class FormFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [

            ])
            ->add('label', TextType::class, [

            ])
            ->add('help', TextType::class, [

            ])
            ->add('required', CheckboxType::class, [

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormField::class,
        ]);
    }
}
