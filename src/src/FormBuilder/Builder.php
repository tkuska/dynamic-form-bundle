<?php

namespace Tkuska\DynamicFormBundle\FormBuilder;

use Symfony\Component\Form\FormTypeInterface;

class Builder
{
    public function __construct(protected iterable $formTypes = []) {}

    public function addFieldType(FormTypeInterface $type){
        $this->formTypes[] = $type;
    }

    public function getFieldTypes(): iterable
    {
        return $this->formTypes;
    }

}