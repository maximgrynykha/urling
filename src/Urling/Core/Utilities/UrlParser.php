<?php

namespace Urling\Core\Utilities;

use Urling\Core\Utilities\Misc\LogicVerifier;
use Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;
use Urling\Core\Utilities\PartParsers\Storages\GluingsStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamespacesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamesStorage;

final class UrlParser
{
    /**
     * Creates lexicon.
     *
     * @param string $url
     *
     * @return array<string, string|null>
     */
    private static function createLexicon(string $url): array
    {
        $lexicon = [
            'scheme'   => self::getScheme($url),
            'host'     => self::getHost($url),
            'port'     => self::getPort($url),
            'user'     => self::getUser($url),
            'pass'     => self::getPass($url),
            'path'     => self::getPath($url),
            'query'    => self::getQuery($url),
            'fragment' => self::getFragment($url),
        ];

        return $lexicon;
    }

    /**
     * Returns value of a part of URL from lexicon
     * (*optional: returns value of URL part from new lexicon genereted for url if passed*).
     *
     * @param string $url
     * @param string $url_part_name
     * @param bool $with_gluing
     *
     * @return string|null
     */
    public static function getPartValueFromUrl(string $url, string $url_part_name, bool $with_gluing = false): ?string
    {
        if (! self::searchUrlPart($url_part_name)) {
            throw new \Exception('You try to access to the value of the nonexistent part of the URL!');
        }

        $lexicon_with_aliases = self::getPartsFromUrlWithAliases($url, $with_gluing);

        $accessor = current(array_filter(
            array_keys($lexicon_with_aliases),
            fn (string $aliases) => mb_strpos($aliases, $url_part_name) !== false
        ));

        if (LogicVerifier::verify(fn () => LogicVerifier::isNotIssetOrEmpty($accessor))) {
            throw new \Exception('You try to access to the value of the nonexistent part of the URL!');
        }

        $value = $lexicon_with_aliases[$accessor];

        return $value ?? null;
    }

    /**
     * Returns array of URL part values (with name for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*).
     *
     * @param string $url
     * @param bool $with_gluings
     *
     * @return array<string, string|null>
     */
    public static function getPartsFromUrl(string $url, bool $with_gluings = false): array
    {
        $lexicon = self::createLexicon($url);

        return (! $with_gluings) ? $lexicon : self::getPartsWithGluings($lexicon);
    }

    /**
     * Returns array of URL part values (with name and aliasee for each value) in url
     * (*optional return array of URL part values from new lexicon generated for url if passed*).
     *
     * @param string $url
     * @param bool $with_gluings
     *
     * @return array<string, string|null>
     */
    public static function getPartsFromUrlWithAliases(string $url, bool $with_gluings = false): array
    {
        $lexicon = self::createLexicon($url);
        $aliases = self::getAliases();

        $lexicon = [
            'scheme|'.$aliases['scheme']     => $lexicon['scheme'],
            'host|'.$aliases['host']         => $lexicon['host'],
            'port|'.$aliases['port']         => $lexicon['port'],
            'user|'.$aliases['user']         => $lexicon['user'],
            'pass|'.$aliases['pass']         => $lexicon['pass'],
            'path|'.$aliases['path']         => $lexicon['path'],
            'query|'.$aliases['query']       => $lexicon['query'],
            'fragment|'.$aliases['fragment'] => $lexicon['fragment'],
        ];

        return (! $with_gluings) ? $lexicon : self::getPartsWithGluings($lexicon);
    }

    /**
     * Searches Url part by origin name or by it alias.
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
            $name_with_alias = explode('|', $name_with_alias);
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
            'scheme'   => AliasesStorage::getAliases(NamespacesStorage::getNamespace('scheme')),
            'host'     => AliasesStorage::getAliases(NamespacesStorage::getNamespace('host')),
            'port'     => AliasesStorage::getAliases(NamespacesStorage::getNamespace('port')),
            'user'     => AliasesStorage::getAliases(NamespacesStorage::getNamespace('user')),
            'pass'     => AliasesStorage::getAliases(NamespacesStorage::getNamespace('pass')),
            'path'     => AliasesStorage::getAliases(NamespacesStorage::getNamespace('path')),
            'query'    => AliasesStorage::getAliases(NamespacesStorage::getNamespace('query')),
            'fragment' => AliasesStorage::getAliases(NamespacesStorage::getNamespace('fragment')),
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
        $scheme = 'scheme';
        $query = 'query';
        $fragment = 'fragment';

        if ($is_aliases_mode) {
            $aliases = self::getAliases();

            $scheme_aliases = $aliases[$scheme];
            $query_aliases = $aliases[$query];
            $fragment_aliases = $aliases[$fragment];

            $scheme .= '|'.$scheme_aliases;
            $query .= '|'.$query_aliases;
            $fragment .= '|'.$fragment_aliases;
        }

        $scheme_gluing = GluingsStorage::getGluing(NamespacesStorage::getNamespace($scheme));
        $query_gluing = GluingsStorage::getGluing(NamespacesStorage::getNamespace($query));
        $fragment_gluing = GluingsStorage::getGluing(NamespacesStorage::getNamespace($fragment));

        if (isset($lexicon[$scheme])) {
            $lexicon[$scheme] = $lexicon[$scheme].$scheme_gluing;
        }
        if (isset($lexicon[$query])) {
            $lexicon[$query] = $query_gluing.$lexicon[$query];
        }
        if (isset($lexicon[$fragment])) {
            $lexicon[$fragment] = $fragment_gluing.$lexicon[$fragment];
        }

        return $lexicon;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getScheme(string $url): ?string
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);

        if ($scheme === false || $scheme === null) {
            $scheme = null;
        }

        return $scheme;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getHost(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_SCHEME);

        if ($host === false || $host === null) {
            $host = null;
        }

        return $host;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getPort(string $url): ?string
    {
        $port = parse_url($url, PHP_URL_SCHEME);

        if ($port === false || $port === null) {
            $port = null;
        }

        return $port;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getUser(string $url): ?string
    {
        $user = parse_url($url, PHP_URL_SCHEME);

        if ($user === false || $user === null) {
            $user = null;
        }

        return $user;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getPass(string $url): ?string
    {
        $pass = parse_url($url, PHP_URL_SCHEME);

        if ($pass === false || $pass === null) {
            $pass = null;
        }

        return $pass;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getPath(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_SCHEME);

        if ($path === false || $path === null) {
            $path = null;
        }

        return $path;
    }

    public static function getQuery(string $url): ?string
    {
        $query = parse_url($url, PHP_URL_SCHEME);

        if ($query === false || $query === null) {
            $query = null;
        }

        return $query;
    }

    /**
     * @param string $url
     *
     * @return string|null
     */
    public static function getFragment(string $url): ?string
    {
        $fragment = parse_url($url, PHP_URL_SCHEME);

        if ($fragment === false || $fragment === null) {
            $fragment = null;
        }

        return $fragment;
    }
}
