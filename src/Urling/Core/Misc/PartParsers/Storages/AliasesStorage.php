<?php

namespace Urling\Core\Misc\PartParsers\Storages;

abstract class AliasesStorage
{
    /**
     * @param string $namespace
     *
     * @return string
     */
    public static function getAliases(string $namespace = ""): string
    {
        return self::aliases()[$namespace];
    }

    /**
     * @return array<int, string>
     */
    public static function getAllAliases(): array
    {
        return array_values(self::aliases());
    }

    /**
     * @param string $alias
     *
     * @return string
     */
    public static function getNamespaceByAlias(string $alias): string
    {
        $all_aliases = self::getAllAliases();

        $accessor = current(array_filter(
            $all_aliases,
            fn (string $aliases_string) => mb_strpos($aliases_string, $alias) !== false
        ));

        if (!$accessor) {
            throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
        }

        return array_flip(self::aliases())[$accessor];
    }

    /**
     * @return array<string, string>
     */
    protected static function aliases(): array
    {
        return [
            NamespacesStorage::$scheme   => "protocol",
            NamespacesStorage::$user     => "username",
            NamespacesStorage::$pass     => "password",
            NamespacesStorage::$host     => "hostname|domain",
            NamespacesStorage::$port     => "",
            NamespacesStorage::$path     => "routes",
            NamespacesStorage::$query    => "params|attributes",
            NamespacesStorage::$fragment => "anchor",
        ];
    }
}
