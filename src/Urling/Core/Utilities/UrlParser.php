<?php

namespace Urling\Core\Utilities;

use Urling\Core\Utilities\Misc\LogicVerifier;
use Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamespacesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamesStorage;
use Urling\Core\Utilities\PartParsers\Storages\GluingsStorage;

final class UrlParser
{
    /**
     * Creates lexicon
     *
     * @param string $url
     *
     * @return void
     */
    private static function createLexicon(string $url): array
    {
        $parsed_resource = parse_url($url);

        $lexicon = [
            "scheme"   => (!empty($parsed_resource["scheme"]))   ? $parsed_resource["scheme"]   : null,
            "host"     => (!empty($parsed_resource["host"]))     ? $parsed_resource["host"]     : null,
            "port"     => (!empty($parsed_resource["port"]))     ? $parsed_resource["port"]     : null,
            "user"     => (!empty($parsed_resource["user"]))     ? $parsed_resource["user"]     : null,
            "pass"     => (!empty($parsed_resource["pass"]))     ? $parsed_resource["pass"]     : null,
            "path"     => (!empty($parsed_resource["path"]))     ? $parsed_resource["path"]     : null,
            "query"    => (!empty($parsed_resource["query"]))    ? $parsed_resource["query"]    : null,
            "fragment" => (!empty($parsed_resource["fragment"])) ? $parsed_resource["fragment"] : null,
        ];

        return $lexicon;
    }

    /**
     * Returns value of a part of URL from lexicon
     * (*optional: returns value of URL part from new lexicon genereted for url if passed*)
     *
     * @param string $url
     * @param string $url_part_name
     * @param bool $with_gluing
     *
     * @return string|null
     */
    public static function getPartValueFromUrl(string $url, string $url_part_name, bool $with_gluing = false): ?string
    {
        if (!self::searchUrlPart($url_part_name)) {
            throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
        }

        $lexicon_with_aliases = self::getPartsFromUrlWithAliases($url, $with_gluing);

        $accessor = current(array_filter(
            array_keys($lexicon_with_aliases),
            fn(string $aliases) => mb_strpos($aliases, $url_part_name) !== false
        ));

        if (LogicVerifier::verify(fn() => LogicVerifier::isNotIssetOrEmpty($accessor))) {
            throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
        }

        $value = $lexicon_with_aliases[$accessor];

        return $value ?? null;
    }

    /**
     * Returns array of URL part values (with name for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*)
     *
     * @param string $url
     * @param bool $with_gluings
     *
     * @return array
     */
    public static function getPartsFromUrl(string $url, bool $with_gluings = false): array
    {
        $lexicon = self::createLexicon($url);

        return (!$with_gluings) ? $lexicon : self::getPartsWithGluings($lexicon);
    }

    /**
     * Returns array of URL part values (with name and aliasee for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*)
     *
     * @param string $url
     * @param bool $with_gluings
     *
     * @return array
     */
    public static function getPartsFromUrlWithAliases(string $url, bool $with_gluings = false): array
    {
        $lexicon = self::createLexicon($url);
        $aliases = self::getAliases();

        $lexicon = [
            "scheme|" . $aliases["scheme"]     => (!empty($lexicon["scheme"]))   ? $lexicon["scheme"]   : null,
            "host|" . $aliases["host"]         => (!empty($lexicon["host"]))     ? $lexicon["host"]     : null,
            "port|" . $aliases["port"]         => (!empty($lexicon["port"]))     ? $lexicon["port"]     : null,
            "port|" . $aliases["port"]         => (!empty($lexicon["port"]))     ? $lexicon["port"]     : null,
            "user|" . $aliases["user"]         => (!empty($lexicon["user"]))     ? $lexicon["user"]     : null,
            "pass|" . $aliases["pass"]         => (!empty($lexicon["pass"]))     ? $lexicon["pass"]     : null,
            "path|" . $aliases["path"]         => (!empty($lexicon["path"]))     ? $lexicon["path"]     : null,
            "query|" . $aliases["query"]       => (!empty($lexicon["query"]))    ? $lexicon["query"]    : null,
            "fragment|" . $aliases["fragment"] => (!empty($lexicon["fragment"])) ? $lexicon["fragment"] : null,
        ];

        return (!$with_gluings) ? $lexicon : self::getPartsWithGluings($lexicon);
    }

    /**
     * Searches Url part by origin name or by it alias
     *
     * @param string $url_part_name
     *
     * @return bool
     */
    public static function searchUrlPart(string $url_part_name): bool
    {
        $names = NamesStorage::getAllNames();
        $aliases = AliasesStorage::getAllAliases();

        $names_with_aliases = array_merge($names, $aliases);

        $_names_with_aliases = [];

        foreach ($names_with_aliases as $name_with_alias) {
            $name_with_alias = explode("|", $name_with_alias);
            $_names_with_aliases = array_merge($_names_with_aliases, $name_with_alias);
        }

        return in_array($url_part_name, $_names_with_aliases);
    }

    /**
     * @return array
     */
    protected static function getAliases(): array
    {
        return [
            "scheme"   => AliasesStorage::getAliases(NamespacesStorage::getNamespace("scheme")),
            "host"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("host")),
            "port"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("port")),
            "user"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("user")),
            "pass"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("pass")),
            "path"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("path")),
            "query"    => AliasesStorage::getAliases(NamespacesStorage::getNamespace("query")),
            "fragment" => AliasesStorage::getAliases(NamespacesStorage::getNamespace("fragment")),
        ];
    }

    /**
     * @param array $lexicon
     * @param bool $is_aliases_mode
     *
     * @return array
     */
    protected static function getPartsWithGluings(array $lexicon, bool $is_aliases_mode = false): array
    {
        $scheme   = "scheme";
        $query    = "query";
        $fragment = "fragment";

        if ($is_aliases_mode) {
            $aliases = self::getAliases();

            $scheme_aliases   = $aliases[$scheme];
            $query_aliases    = $aliases[$query];
            $fragment_aliases = $aliases[$fragment];

            $scheme   .= "|" . $scheme_aliases;
            $query    .= "|" . $query_aliases;
            $fragment .= "|" . $fragment_aliases;
        }

        $scheme_gluing   = GluingsStorage::getGluing(NamespacesStorage::getNamespace($scheme));
        $query_gluing    = GluingsStorage::getGluing(NamespacesStorage::getNamespace($query));
        $fragment_gluing = GluingsStorage::getGluing(NamespacesStorage::getNamespace($fragment));

        if (isset($lexicon[$scheme])) {
            $lexicon[$scheme] = $lexicon[$scheme] . $scheme_gluing;
        }
        if (isset($lexicon[$query])) {
            $lexicon[$query] = $query_gluing . $lexicon[$query];
        }
        if (isset($lexicon[$fragment])) {
            $lexicon[$fragment] = $fragment_gluing . $lexicon[$fragment];
        }

        return $lexicon;
    }
}
