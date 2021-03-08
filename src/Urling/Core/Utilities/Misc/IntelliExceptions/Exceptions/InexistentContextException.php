<?php

namespace Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions;

use Exception;
use Throwable;

class InexistentContextException extends Exception implements ExceptionParserInterface
{
    public string $exception_message;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->exception_message = $message;

        parent::__construct($message, $code, $previous);
    }

    public function setCustomExceptionMessage(string $message = ""): ?string
    {
        if (isset($message) && !empty($message)) {
            return $this->exception_message = $message;
        }

        return $this->exception_message;
    }

    public function getCustomExceptionMessage(): ?string
    {
        return $this->exception_message ?? null;
    }
}
