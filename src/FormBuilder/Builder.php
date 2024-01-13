<?php

namespace Tkuska\DynamicFormBundle\FormBuilder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormTypeInterface;
use Tkuska\DynamicFormBundle\Entity\Form;

class Builder
{

    public function __construct(private FormFactory $formFactory){

    }
    protected array $formTypes = [];

    public function addFieldType($name, $type){
        $this->formTypes[$name] = $type;
    }

    public function getFieldTypes(): array
    {
        return $this->formTypes;
    }

    public function buildForm(Form $definition): FormInterface
    {
        $form = $this->formFactory->createNamed($definition->getName());
        foreach($definition->getFields() as $field){
            $form->add($field->getName(), $field->getType(), [
                'required' => $field->isRequired(),
                'label' => $field->getLabel(),
                'help' => $field->getHelp()
            ]);
        }

        return $form;
    }

}