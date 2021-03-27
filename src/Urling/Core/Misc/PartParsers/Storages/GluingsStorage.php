<?php

namespace Urling\Core\Misc\PartParsers\Storages;

abstract class GluingsStorage
{
    /**
     * @param string $namespace
     *
     * @return string
     */
    public static function getGluing(string $namespace): string
    {
        return self::gluings()[$namespace];
    }

    /**
     * @return array<int, string>
     */
    public static function getAllGluings(): array
    {
        return array_values(self::gluings());
    }

    /**
     * @return array<string, string>
     */
    protected static function gluings(): array
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
