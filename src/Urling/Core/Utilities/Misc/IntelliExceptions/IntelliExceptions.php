<?php

namespace Urling\Core\Utilities\Misc\IntelliExceptions;

use Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions\UnsupportedMethodException;
use Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions\ExceptionParserInterface;

trait IntelliExceptions
{
    /**
     * @param mixed $method_name
     * @param array<mixed> $method_attributes
     * 
     * @return void
     */
    public function __call($method_name, $method_attributes)
    {
        $class_methods = get_class_methods(get_class($this));
        $class_methods = array_filter($class_methods, function ($method) {
            return (
                mb_strpos($method, "_") === false &&
                mb_strpos($method, "__") === false
            );
        });

        try {
            if (!array_key_exists($method_name, $class_methods)) {
                $exception = new UnsupportedMethodException();
                $exception
                    ->setSupportedMethodNames($class_methods)
                    ->setUnsupportedMethodName($method_name)
                    ->setCustomExceptionMessage();

                throw $exception;
            }

            $this->$method_name($method_attributes);
        } catch (ExceptionParserInterface $exception) {
            throw new \Exception($exception->getCustomExceptionMessage());
        }
    }
}
