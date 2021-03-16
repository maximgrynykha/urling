<?php

namespace Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions;

use Exception;
use Throwable;

class UnsupportedMethodException extends Exception implements ExceptionParserInterface
{
    /** @var array<int, string> */
    public array $supported_method_names;

    public string $unsupported_method_name;
    
    public string $exception_message;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->supported_method_names = [];
        $this->unsupported_method_name = "";

        $message = $this->getCustomExceptionMessage();

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param array<int, string> $names
     * 
     * @return self
     */
    public function setSupportedMethodNames(array $names): self
    {
        $this->supported_method_names = $names;

        return $this;
    }

    /**
     * @param string $name
     * 
     * @return self
     */
    public function setUnsupportedMethodName(string $name): self
    {
        $this->unsupported_method_name = $name;

        return $this;
    }


    /**
     * @param string $message
     * 
     * @return void
     */
    public function setCustomExceptionMessage(string $message = "You try to call unsupported method"): void
    {
        $prediction = array_filter($this->supported_method_names, function ($supported_method_name) {
            $similarity = similar_text($this->unsupported_method_name, $supported_method_name, $percent);

            return (int) $percent > 70;
        });

        if (empty($prediction)) {
            $this->exception_message = $message .= ": '{$this->unsupported_method_name}()'";
        }

        $prediction_count = count($prediction);

        if ($prediction_count || !empty($prediction_count)) {
            switch ($prediction_count) {
                case $prediction_count === 1:
                    $prediction = implode("", $prediction);

                    $this->exception_message =
                        $message .=
                        ": {$this->unsupported_method_name}()'."
                        . " Try this one: '{$prediction}()'";

                    break;
                case $prediction_count >= 2:
                    $prediction = "'" . implode("()', '", $prediction) . "()'.";

                    $this->exception_message =
                        $message .=
                        ": '{$this->unsupported_method_name}()'."
                        . " Try one of the following: {$prediction}";
                    
                    break;
                default:
                    $this->exception_message = $message .= ": {$this->unsupported_method_name}.";
            }
        }
    }

    /**
     * @return string|null
     */
    public function getCustomExceptionMessage(): ?string
    {
        return $this->exception_message ?? null;
    }
}
