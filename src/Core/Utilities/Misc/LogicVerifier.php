<?php

namespace Ismaxim\Urling\Core\Utilities\Misc;

use Closure;

abstract class LogicVerifier
{
    /**
     * Example: LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($value))
     * 
     * @param Closure $verifier
     * 
     * @return bool
     */
    public static function verify(Closure $verifier) : bool
    {
        return $verifier(); # AND / OR verifiers
    }

    // AND verifiers

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isIssetAndEmpty($context) : bool
    {
        return isset($context) and empty($context);
    }
    
    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isNotIssetAndEmpty($context) : bool
    {
        return !isset($context) and empty($context);
    }

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isIssetAndNotEmpty($context) : bool
    {
        return isset($context) and !empty($context);
    }

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isNotIssetAndNotEmpty($context) : bool
    {
        return !isset($context) and !empty($context);
    }

    // OR verifiers

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isIssetOrEmpty($context) : bool
    {
        return isset($context) or empty($context);
    }
    
    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isNotIssetOrEmpty($context) : bool
    {
        return !isset($context) or empty($context);
    }

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isIssetAndOrEmpty($context) : bool
    {
        return isset($context) or !empty($context);
    }

    /**
     * @param mixed $context
     * 
     * @return bool
     */
    public static function isNotIssetOrNotEmpty($context) : bool
    {
        return !isset($context) or !empty($context);
    }
}