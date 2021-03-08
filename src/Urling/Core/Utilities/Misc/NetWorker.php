<?php

namespace Urling\Core\Utilities\Misc;

trait NetWorker
{
    public static function getIp(string $resource) : ?string
    {
        $hostname = parse_url($resource)["host"] ?? null;
        
        return (isset($hostname)) ? gethostbyname($hostname) : null;
    }

    public static function getByIp(string $ip_address, bool $complete = false, string $resource = "") : ?string
    {
        // дописать

        if (LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($resource))) {
            return gethostbyaddr(self::getIp($resource));
        } else {
            return gethostbyaddr($ip_address);
        }
    }
}