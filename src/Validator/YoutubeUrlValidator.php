<?php

namespace App\Validator;

use App\Validator\YoutubeUrl;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class YoutubeUrlValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof YoutubeUrl) {
            throw new UnexpectedTypeException($constraint, YoutubeUrl::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
// || !preg_match('/\S*youtu.be\/\S*/', $value, $matches)
        if (!preg_match('/\S*youtube.com\/watch\?v=\S*/', $value, $matches) && !preg_match('/\S*youtu.be\/\S*/', $value, $matches)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ url }}', $value)
                ->addViolation();
        }
    }
}