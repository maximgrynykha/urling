<?php

namespace Urling\Core\Utilities\PartParsers\Storages;

abstract class NamesStorage
{
    public static function getName(string $namespace): ?string
    {
        return self::names()[$namespace];
    }

    public static function getAllNames(): array
    {
        return array_values(self::names());
    }

    protected static function names(): array
    {
        return [
            NamespacesStorage::$scheme   => "scheme",
            NamespacesStorage::$host     => "host",
            NamespacesStorage::$port     => "port",
            NamespacesStorage::$user     => "user",
            NamespacesStorage::$pass     => "pass",
            NamespacesStorage::$path     => "path",
            NamespacesStorage::$query    => "query",
            NamespacesStorage::$fragment => "fragment",
        ];
    }
}
