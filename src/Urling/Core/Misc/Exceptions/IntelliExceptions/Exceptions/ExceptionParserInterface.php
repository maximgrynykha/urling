<?php

namespace Urling\Core\Misc\Exceptions\IntelliExceptions\Exceptions;

interface ExceptionParserInterface
{
    /**
     * @return string
     */
    public function getCustomExceptionMessage(): string;

    /**
     * @return void
     */
    public function setCustomExceptionMessage(string $message = ""): void;
}
