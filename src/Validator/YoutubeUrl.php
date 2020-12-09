<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class YoutubeUrl extends Constraint
{
    public $message = 'Typed Url {{ url }} is not valid YouTube link!';
}