<?php

namespace Urling\Core\Utilities\PartParsers\Storages;

use Urling\PartParsers\FragmentParser;
use Urling\PartParsers\HostParser;
use Urling\PartParsers\PassParser;
use Urling\PartParsers\PathParser;
use Urling\PartParsers\PortParser;
use Urling\PartParsers\QueryParser;
use Urling\PartParsers\SchemeParser;
use Urling\PartParsers\UserParser;

abstract class NamespacesStorage
{
    /**
     * @var string
     */
    public static $scheme   = SchemeParser::class;

    /**
     * @var string
     */
    public static $host     = HostParser::class;

    /**
     * @var string
     */
    public static $port     = PortParser::class;
    
    /**
     * @var string
     */
    public static $user     = UserParser::class;

    /**
     * @var string
     */
    public static $pass     = PassParser::class;

    /**
     * @var string
     */
    public static $path     = PathParser::class;

    /**
     * @var string
     */
    public static $query    = QueryParser::class;

    /**
     * @var string
     */
    public static $fragment = FragmentParser::class;


    /**
     * Also accepts the name of URL part with concatenated aliases
     *
     * @param string $url_part
     *
     * @return string|null
     */
    public static function getNamespace(string $url_part): ?string
    {
        $url_part = explode("|", $url_part);

        switch ($url_part) {
            case in_array("scheme", $url_part):
                return self::$scheme;
            case in_array("host", $url_part):
                return self::$host;
            case in_array("port", $url_part):
                return self::$port;
            case in_array("user", $url_part):
                return self::$user;
            case in_array("pass", $url_part):
                return self::$pass;
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
