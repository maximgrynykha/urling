<?php

namespace Urling\Core\Utilities;

use Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamespacesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamesStorage;
use Urling\Core\Utilities\PartParsers\Storages\GluingsStorage;

final class UrlParser
{
    /**
     * Creates lexicon
     *
     * @param string|null $url
     *
     * @return array<string, string|null>
     */
    private static function createLexicon(?string $url): array
    {
        $lexicon = [
            "scheme"   => self::getScheme($url),
            "user"     => self::getUser($url),
            "pass"     => self::getPass($url),
            "host"     => self::getHost($url),
            "port"     => self::getPort($url),
            "path"     => self::getPath($url),
            "query"    => self::getQuery($url),
            "fragment" => self::getFragment($url),
        ];

        return $lexicon;
    }

    /**
     * Returns value of a part of URL from lexicon
     * (*optional: returns value of URL part from new lexicon genereted for url if passed*)
     *
     * @param string|null $url
     * @param string $url_part_name
     * @param bool $with_gluing
     *
     * @return string|null
     */
    public static function getPartValueFromUrl(?string $url, string $url_part_name, bool $with_gluing = false): ?string
    {
        if ($url) {
            if (!self::searchUrlPart($url_part_name)) {
                throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
            }

            $lexicon_with_aliases = self::getPartsFromUrlWithAliases($url, $with_gluing);

            $accessor = current(array_filter(
                array_keys($lexicon_with_aliases),
                fn(string $aliases) => mb_strpos($aliases, $url_part_name) !== false
            ));

            if (!$accessor) {
                throw new \Exception("You try to access to the value of the nonexistent part of the URL!");
            }

            $value = $lexicon_with_aliases[$accessor];
        }

        return $value ?? null;
    }

    /**
     * Returns array of URL part values (with name for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*)
     *
     * @param string|null $url
     * @param bool $with_gluings
     *
     * @return array<string, string|null>
     */
    public static function getPartsFromUrl(?string $url, bool $with_gluings = false): array
    {
        if ($url) {
            $lexicon = self::createLexicon($url);

            $parts = ($with_gluings)
                ? self::getPartsWithGluings($lexicon)
                : $lexicon;
        }

        return $parts ?? [];
    }

    /**
     * Returns array of URL part values (with name and aliasee for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*)
     *
     * @param string|null $url
     * @param bool $with_gluings
     *
     * @return array<string, string|null>
     */
    public static function getPartsFromUrlWithAliases(?string $url, bool $with_gluings = false): array
    {
        if ($url) {
            $lexicon = self::createLexicon($url);
            $aliases = self::getAliases();

            $lexicon = [
                "scheme|" . $aliases["scheme"]     => $lexicon["scheme"],
                "user|" . $aliases["user"]         => $lexicon["user"],
                "pass|" . $aliases["pass"]         => $lexicon["pass"],
                "host|" . $aliases["host"]         => $lexicon["host"],
                "port|" . $aliases["port"]         => $lexicon["port"],
                "path|" . $aliases["path"]         => $lexicon["path"],
                "query|" . $aliases["query"]       => $lexicon["query"],
                "fragment|" . $aliases["fragment"] => $lexicon["fragment"],
            ];

            $parts_with_aliases = ($with_gluings)
                ? self::getPartsWithGluings($lexicon)
                : $lexicon;
        }

        return $parts_with_aliases ?? [];
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
     * @return array<string, string>
     */
    protected static function getAliases(): array
    {
        return [
            "scheme"   => AliasesStorage::getAliases(NamespacesStorage::getNamespace("scheme")),
            "user"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("user")),
            "pass"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("pass")),
            "host"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("host")),
            "port"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("port")),
            "path"     => AliasesStorage::getAliases(NamespacesStorage::getNamespace("path")),
            "query"    => AliasesStorage::getAliases(NamespacesStorage::getNamespace("query")),
            "fragment" => AliasesStorage::getAliases(NamespacesStorage::getNamespace("fragment")),
        ];
    }

    /**
     * @param array<string, string|null> $lexicon
     * @param bool $is_aliases_mode
     *
     * @return array<string, string|null>
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

    /**
     * @return array<int, string>
     */
    public static function getUrlPartNames(): array
    {
        return [
            "scheme",
            "user",
            "pass",
            "host",
            "port",
            "path",
            "query",
            "fragment"
        ];
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getScheme(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_SCHEME) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getUser(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_USER) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getPass(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_PASS) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getHost(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_HOST) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getPort(?string $url): ?string
    {
        return ($url) ? ((string) parse_url($url, PHP_URL_PORT) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getPath(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_PATH) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getQuery(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_QUERY) ?: null) : null;
    }

    /**
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getFragment(?string $url): ?string
    {
        return ($url) ? (parse_url($url, PHP_URL_FRAGMENT) ?: null) : null;
    }
}
