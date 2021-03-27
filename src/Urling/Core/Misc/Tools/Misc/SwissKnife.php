<?php

namespace Urling\Core\Misc\Tools\Misc;

trait SwissKnife
{
    /**
     * @param string $resource
     *
     * @return string
     */
    public static function truncateExtraSlashes(string $resource): string
    {
        return str_replace(':/', '://', trim((string) preg_replace('/\/+/', '/', $resource), '/'));
    }

    /**
     * @param string|null $string
     * @param string|null $_string
     *
     * @return bool
     */
    public static function isSameStrings(?string $string, ?string $_string): bool
    {
        return !strcmp((string) $string, (string) $_string);
    }

    /**
     * @param string|null $string
     *
     * @return bool
     */
    public static function isUppercased(?string $string): bool
    {
        return self::isSameStrings(mb_strtoupper((string) $string), (string) $string);
    }

    /**
     * @param string|null $string
     *
     * @return bool
     */
    public static function isLowercased(?string $string): bool
    {
        return self::isSameStrings(mb_strtolower((string) $string), (string) $string);
    }
}
