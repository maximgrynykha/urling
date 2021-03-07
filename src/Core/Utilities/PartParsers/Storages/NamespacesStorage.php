<?php

namespace Ismaxim\Urling\Core\Utilities\PartParsers\Storages;

use Ismaxim\Urling\PartParsers\FragmentParser;
use Ismaxim\Urling\PartParsers\HostParser;
use Ismaxim\Urling\PartParsers\PassParser;
use Ismaxim\Urling\PartParsers\PathParser;
use Ismaxim\Urling\PartParsers\PortParser;
use Ismaxim\Urling\PartParsers\QueryParser;
use Ismaxim\Urling\PartParsers\SchemeParser;
use Ismaxim\Urling\PartParsers\UserParser;

abstract class NamespacesStorage
{
    public static $scheme   = SchemeParser::class;
    public static $host     = HostParser::class;
    public static $port     = PortParser::class;
    public static $user     = UserParser::class;
    public static $pass     = PassParser::class;
    public static $path     = PathParser::class;
    public static $query    = QueryParser::class;
    public static $fragment = FragmentParser::class;

    /**
     * Also accepts the name of URL part with concatenated aliases
     * 
     * @param string $url_part
     * 
     * @return string|null
     */
    public static function getNamespace(string $url_part) : ?string
    {
        $url_part = explode("|", $url_part);

        switch ($url_part) {
            case in_array("scheme", $url_part)   : return self::$scheme;
            case in_array("host", $url_part)     : return self::$host;
            case in_array("port", $url_part)     : return self::$port;
            case in_array("user", $url_part)     : return self::$user;
            case in_array("pass", $url_part)     : return self::$pass;
            case in_array("path", $url_part)     : return self::$path;
            case in_array("query", $url_part)    : return self::$query;
            case in_array("fragment", $url_part) : return self::$fragment;
            default : 
                throw new \Exception("Unsupported URL part!");
        }
    }

    /**
     * @return array
     */
    public static function getAllNamespaces() : array
    {
        return array_values(get_class_vars(self::class));
    }
}