<?php

namespace Ismaxim\Urling\Core\Utilities\PartParsers\Storages;

abstract class GluingsStorage
{
    public static function getGluing(string $namespace) : ?string
    {
        return self::gluings()[$namespace];
    }

    public static function getAllGluings() : array
    {
        return array_values(self::gluings());
    }

    protected static function gluings() : array
    {
        return [
            NamespacesStorage::$scheme   => "://",
            NamespacesStorage::$user     => "",
            NamespacesStorage::$pass     => ":",
            NamespacesStorage::$host     => "",
            NamespacesStorage::$port     => ":",
            NamespacesStorage::$path     => "/",
            NamespacesStorage::$query    => "?",
            NamespacesStorage::$fragment => "#",
        ];
    }
}