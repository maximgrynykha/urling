<?php

namespace Urling\Core\Misc\Tools\Misc;

/**
 * @deprecated
 */
trait Assertion
{
    // ---------------------------------------------------------
    // AND assertions
    // ---------------------------------------------------------

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullAndEmpty(&$context): bool
    {
        return !is_null($context) and empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullAndEmpty(&$context): bool
    {
        return is_null($context) and empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullAndNotEmpty(&$context): bool
    {
        return !is_null($context) and !empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullAndNotEmpty(&$context): bool
    {
        return is_null($context) and !empty($context);
    }

    // ---------------------------------------------------------
    // OR assertions
    // ---------------------------------------------------------

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullOrEmpty(&$context): bool
    {
        return !is_null($context) or empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullOrEmpty(&$context): bool
    {
        return is_null($context) or empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNotNullOrOrEmpty(&$context): bool
    {
        return !is_null($context) or !empty($context);
    }

    /**
     * @deprecated
     *
     * @param mixed $context
     *
     * @return bool
     */
    public static function isNullOrNotEmpty(&$context): bool
    {
        return is_null($context) or !empty($context);
    }
}
