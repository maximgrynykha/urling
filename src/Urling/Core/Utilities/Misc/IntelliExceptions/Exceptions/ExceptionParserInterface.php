<?php

namespace Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions;

interface ExceptionParserInterface
{
    /**
     * @return string|null
     */
    public function getCustomExceptionMessage(): ?string;

    /**
     * @return void
     */
    public function setCustomExceptionMessage(string $message = ""): void;
}
