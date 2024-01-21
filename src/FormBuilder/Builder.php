<?php

namespace Tkuska\DynamicFormBundle\FormBuilder;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\ErrorHandler\ErrorRenderer\FileLinkFormatter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Tkuska\DynamicFormBundle\Entity\Form;

class Builder
{

    public function __construct(
        private FormRegistryInterface $formRegistry,
        private array $namespaces = ['Symfony\Component\Form\Extension\Core\Type'],
        private array $types = [],
        private array $extensions = [],
        private array $guessers = []){

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

    public function getFieldTypes(): array
    {
        $fieldTypes = [];

        $fieldTypes['core'] = array_flip($this->getCoreTypes());
        $fieldTypes['service'] = array_flip($this->getServiceTypes());

        return $fieldTypes;
    }

    private function getServiceTypes(): array
    {
        return array_values(array_diff($this->types, $this->getCoreTypes()));
    }


    private function getCoreTypes(): array
    {
        $coreExtension = new CoreExtension();
        $loadTypesRefMethod = (new \ReflectionObject($coreExtension))->getMethod('loadTypes');
        $coreTypes = $loadTypesRefMethod->invoke($coreExtension);
        $coreTypes = array_map(static fn (FormTypeInterface $type) => $type::class, $coreTypes);
        sort($coreTypes);

        return $coreTypes;
    }

    public function getOptions($class){

        if (!class_exists($class) || !is_subclass_of($class, FormTypeInterface::class)) {
            $class = $this->getFqcnTypeClass($input, $io, $class);
        }
        $resolvedType = $this->formRegistry->getType($class);

    }

    private function getFqcnTypeClass(InputInterface $input, SymfonyStyle $io, string $shortClassName): string
    {
        $classes = $this->getFqcnTypeClasses($shortClassName);

        if (0 === $count = \count($classes)) {
            $message = sprintf("Could not find type \"%s\" into the following namespaces:\n    %s", $shortClassName, implode("\n    ", $this->namespaces));

            $allTypes = array_merge($this->getCoreTypes(), $this->types);
            if ($alternatives = $this->findAlternatives($shortClassName, $allTypes)) {
                if (1 === \count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }
                $message .= implode("\n    ", $alternatives);
            }

            throw new InvalidArgumentException($message);
        }
        if (1 === $count) {
            return $classes[0];
        }
        if (!$input->isInteractive()) {
            throw new InvalidArgumentException(sprintf("The type \"%s\" is ambiguous.\n\nDid you mean one of these?\n    %s.", $shortClassName, implode("\n    ", $classes)));
        }

        return $io->choice(sprintf("The type \"%s\" is ambiguous.\n\nSelect one of the following form types to display its information:", $shortClassName), $classes, $classes[0]);
    }

    private function getFqcnTypeClasses(string $shortClassName): array
    {
        $classes = [];
        sort($this->namespaces);
        foreach ($this->namespaces as $namespace) {
            if (class_exists($fqcn = $namespace.'\\'.$shortClassName)) {
                $classes[] = $fqcn;
            } elseif (class_exists($fqcn = $namespace.'\\'.ucfirst($shortClassName))) {
                $classes[] = $fqcn;
            } elseif (class_exists($fqcn = $namespace.'\\'.ucfirst($shortClassName).'Type')) {
                $classes[] = $fqcn;
            } elseif (str_ends_with($shortClassName, 'type') && class_exists($fqcn = $namespace.'\\'.ucfirst(substr($shortClassName, 0, -4).'Type'))) {
                $classes[] = $fqcn;
            }
        }

        return $classes;
    }

}