<?php

namespace SocialMedia\Poster\Exceptions;

use Exception;
use Throwable;

class MissingSocialMediaSettingsException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
