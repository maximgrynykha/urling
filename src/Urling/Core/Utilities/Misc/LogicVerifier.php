<?php

namespace Urling\Core\Utilities\Misc;

use Closure;

abstract class LogicVerifier
{
    /**
     * Example: LogicVerifier::verify(fn() => LogicVerifier::isNotNullAndNotEmpty($value))
     *
     * @param Closure $verifier
     *
     * @return bool
     */
    public static function verify(Closure $verifier): bool
    {
        return $verifier(); # AND / OR verifiers
    }

    // AND verifiers

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullAndEmpty($context): bool
    {
        return !is_null($context) and empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullAndEmpty($context): bool
    {
        return is_null($context) and empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullAndNotEmpty($context): bool
    {
        return !is_null($context) and !empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullAndNotEmpty($context): bool
    {
        return is_null($context) and !empty($context);
    }

    // OR verifiers

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullOrEmpty($context): bool
    {
        return !is_null($context) or empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullOrEmpty($context): bool
    {
        return is_null($context) or empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullOrOrEmpty($context): bool
    {
        return !is_null($context) or !empty($context);
    }

    /**
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullOrNotEmpty($context): bool
    {
        return is_null($context) or !empty($context);
    }
}
