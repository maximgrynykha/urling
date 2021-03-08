<?php 

namespace Urling\Core\Utilities\Misc\IntelliExceptions\Exceptions;

use Exception;
use Throwable;

class UnsupportedMethodException extends Exception implements ExceptionParserInterface
{
    public array $supported_method_names;
    public string $unsupported_method_name;
    public string $exception_message;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->supported_method_names = [];
        $this->unsupported_method_name = "";
        $this->exception_message = "You try to call unsupported method";
        
        $message = $this->getCustomExceptionMessage();
        parent::__construct($message, $code, $previous);
    }

    public function setSupportedMethodNames(array $names)
    {
        $this->supported_method_names = $names;

        return $this;
    }

    public function setUnsupportedMethodName(string $name)
    {
        $this->unsupported_method_name = $name;
        
        return $this;
    }

    
    public function setCustomExceptionMessage(string $message = "") : ?string
    {
        if (isset($message) && !empty($message)) {
            return $this->exception_message = $message;
        }

        $prediction = array_filter($this->supported_method_names, function ($supported_method_name) {
            $similarity = similar_text($this->unsupported_method_name, $supported_method_name, $percent);

            return (int) $percent > 70;
        });
        
        if (!isset($prediction) || empty($prediction)) {
            return $this->exception_message .= ": '{$this->unsupported_method_name}()'";
        }

        $prediction_count = count($prediction);

        if (isset($prediction_count) || !empty($prediction_count) || $prediction_count) {
            switch ($prediction_count) {
                case $prediction_count === 1 : 
                    $prediction = implode("", $prediction);
                    
                    return $this->exception_message .= 
                        ": {$this->unsupported_method_name}()'."
                        ." Try this one: '{$prediction}()'";    

                case $prediction_count >= 2 : 
                    $prediction = "'". implode("()', '", $prediction) . "()'.";
                    
                    return $this->exception_message .=
                        ": '{$this->unsupported_method_name}()'."
                        ." Try one of the following: {$prediction}"; 

                default :
                    return $this->exception_message .= ": {$this->unsupported_method_name}.";
            }
        }
    }

    public function getCustomExceptionMessage() : ?string
    {
        return $this->exception_message ?? null;
    }
}