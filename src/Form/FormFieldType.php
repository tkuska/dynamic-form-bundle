<?php

namespace Tkuska\DynamicFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tkuska\DynamicFormBundle\Entity\Form;
use Tkuska\DynamicFormBundle\Entity\FormField;
use Tkuska\DynamicFormBundle\FormBuilder\Builder;

class FormFieldType extends AbstractType
{
    public function __construct(private Builder $builder){
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => $this->builder->getFieldTypes()
            ])
            ->add('label', TextType::class, [
                'required' => false,

            ])
            ->add('help', TextType::class, [
                'required' => false,

            ])
            ->add('required', CheckboxType::class, [
                'required' => false,

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
