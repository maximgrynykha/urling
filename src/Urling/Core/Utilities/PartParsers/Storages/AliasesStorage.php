<?php

namespace Urling\Core\Utilities\PartParsers\Storages;

use Urling\Core\Utilities\Misc\LogicVerifier;

abstract class AliasesStorage
{
    public static function getAliases(string $namespace = ""): ?string
    {
        return self::aliases()[$namespace];
    }

    public static function getAllAliases(): array
    {
        return array_values(self::aliases());
    }

    public static function getNamespaceByAlias(string $alias): string
    {
        $all_aliases = self::getAllAliases();

        $accessor = current(array_filter(
            $all_aliases,
            fn(string $aliases_string) => mb_strpos($aliases_string, $alias) !== false
        ));

        if (LogicVerifier::verify(fn() => LogicVerifier::isNotIssetOrEmpty($accessor))) {
            throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
        }

        return array_flip(self::aliases())[$accessor];
    }

    protected static function aliases(): array
    {
        return [
            NamespacesStorage::$scheme   => "protocol",
            NamespacesStorage::$host     => "hostname|domain",
            NamespacesStorage::$port     => "",
            NamespacesStorage::$user     => "username",
            NamespacesStorage::$pass     => "password",
            NamespacesStorage::$path     => "routes",
            NamespacesStorage::$query    => "params|attributes",
            NamespacesStorage::$fragment => "anchor",
        ];
    }
}
