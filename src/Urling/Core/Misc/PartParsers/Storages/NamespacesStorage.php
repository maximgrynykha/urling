<?php

namespace Urling\Core\Misc\PartParsers\Storages;

use Urling\PartParsers\SchemeParser;
use Urling\PartParsers\UserParser;
use Urling\PartParsers\PassParser;
use Urling\PartParsers\HostParser;
use Urling\PartParsers\PortParser;
use Urling\PartParsers\PathParser;
use Urling\PartParsers\QueryParser;
use Urling\PartParsers\FragmentParser;

abstract class NamespacesStorage
{
    public static string $scheme   = SchemeParser::class;
    public static string $user     = UserParser::class;
    public static string $pass     = PassParser::class;
    public static string $host     = HostParser::class;
    public static string $port     = PortParser::class;
    public static string $path     = PathParser::class;
    public static string $query    = QueryParser::class;
    public static string $fragment = FragmentParser::class;

    /**
     * Also accepts the name of URL part with concatenated aliases
     *
     * @param string $url_part
     *
     * @return string
     */
    public static function getNamespace(string $url_part): string
    {
        $url_part = explode("|", $url_part);

        switch ($url_part) {
            case in_array("scheme", $url_part):
                return self::$scheme;
            case in_array("user", $url_part):
                return self::$user;
            case in_array("pass", $url_part):
                return self::$pass;
            case in_array("host", $url_part):
                return self::$host;
            case in_array("port", $url_part):
                return self::$port;
            case in_array("path", $url_part):
                return self::$path;
            case in_array("query", $url_part):
                return self::$query;
            case in_array("fragment", $url_part):
                return self::$fragment;
            default:
                throw new \Exception("Unsupported URL part!");
        }
    }

    /**
     * @return array<int, string>
     */
    public static function getAllNamespaces(): array
    {
        return array_values(get_class_vars(self::class));
    }
}
