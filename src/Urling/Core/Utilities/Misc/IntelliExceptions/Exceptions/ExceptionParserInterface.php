<?php

namespace Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions;

interface ExceptionParserInterface
{
    public function setCustomExceptionMessage();
    public function getCustomExceptionMessage();
}