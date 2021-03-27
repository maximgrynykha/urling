<?php

namespace Urling\Core\Misc\Tools\Misc;

use Urling\Core\Misc\UrlParser;

trait NetWorker
{
    /**
     * @param string $resource
     * 
     * @return string|null
     */
    public static function getIp(string $resource): ?string
    {
        $hostname = UrlParser::getHost($resource);

        return ($hostname) ? gethostbyname($hostname) : null;
    }

    /**
     * @param string $ip_address
     * 
     * @return string|null
     */
    public static function getByIp(string $ip_address): ?string
    {
        return gethostbyaddr($ip_address) ?: null;
    }
}
