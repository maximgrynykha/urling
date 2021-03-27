<?php

namespace Urling\Core\Misc\PartParsers\Storages;

abstract class NamesStorage
{
    /**
     * @param string $namespace
     *
     * @return string
     */
    public static function getName(string $namespace): string
    {
        return self::names()[$namespace];
    }

    /**
     * @return array<int, string>
     */
    public static function getAllNames(): array
    {
        return array_values(self::names());
    }

    /**
     * @return array<string, string>
     */
    protected static function names(): array
    {
        return [
            NamespacesStorage::$scheme   => "scheme",
            NamespacesStorage::$user     => "user",
            NamespacesStorage::$pass     => "pass",
            NamespacesStorage::$host     => "host",
            NamespacesStorage::$port     => "port",
            NamespacesStorage::$path     => "path",
            NamespacesStorage::$query    => "query",
            NamespacesStorage::$fragment => "fragment",
        ];
    }
}
