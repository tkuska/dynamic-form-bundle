<?php

namespace Tkuska\DynamicFormBundle\Validator;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DuplicatedFieldNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\DuplicatedFieldName $constraint */

        if (null === $value || '' === $value || !$value instanceof Collection) {
            return;
        }
        $names = [];
        foreach ($value as $item) {
            if (in_array($item->getName(), $names)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ inputName }}', $item->getName())
                    ->addViolation();
                break;
            }
            $names[] = $item->getName();
        }

    }
}
