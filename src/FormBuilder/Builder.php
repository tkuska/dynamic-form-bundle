<?php

namespace Tkuska\DynamicFormBundle\FormBuilder;

use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormTypeInterface;

class Builder
{
    protected array $formTypes = [];

    public function addFieldType($name, $type){
        $this->formTypes[$name] = $type;
    }

    public function getFieldTypes(): array
    {
        return $this->formTypes;
    }

}