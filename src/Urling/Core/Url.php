<?php

namespace Urling\Core;

use Urling\Core\Misc\UrlParser;
use Urling\Core\Misc\Tools\Tools;
use Urling\Core\Misc\BaseEditors\BaseUrlEditor;
use Urling\Core\Misc\PartParsers\Registrars\AliasesRegistrar;
use Urling\Core\Misc\PartParsers\Registrars\ParsersRegistrar;
use Urling\Core\Misc\Exceptions\IntelliExceptions\IntelliExceptions;
use Webmozart\Assert\Assert;

final class Url
{
    use ParsersRegistrar;
    use AliasesRegistrar;
    use IntelliExceptions;
    use BaseUrlEditor;

    protected ?string $origin;

    public function __construct(string $url = null)
    {
        $this->origin = trim((string) $url);
        $this->bootstrap();

        if (mb_strlen((string) $this->origin) && !$this->get()) {
            throw new \Exception("Incorrect URL passed!");
        }
    }

    /**
     * @return void
     */
    protected function bootstrap(): void
    {
        $this->registerParsers();
        $this->registerAliases();
    }

    /**
     * @param array<string, string|null> $url_parts
     *
     * @return string|null
     */
    public function construct(array $url_parts): ?string
    {
        $parts = array_keys($url_parts);
        $values = array_values($url_parts);

        foreach ($parts as $index => $part) {
            if (!UrlParser::searchUrlPart($part)) {
                throw new \Exception("Unsupported name or alias for the part of URL: $part!");
            }

            $this->{$part}->add($values[$index]);
        }

        return $this->get();
    }

    /**
     * @param string $url
     * @param string|null $origin
     * @param bool $verify_protocols
     *
     * @return bool
     */
    public function isSameOrigin(string $url, string $origin = null, bool $verify_protocols = true): bool
    {
        if (!($origin = $origin ?: $this->origin)) {
            return false;
        }

        if (($verify_protocols && ($url && $origin))) {
            $url_protocol = UrlParser::getPartValueFromUrl($url, "protocol");
            $origin_protocol = UrlParser::getPartValueFromUrl($origin, "protocol");

            if (!Assert::same((string) $url_protocol, (string) $origin_protocol)) {
                return false;
            }
        }

        $url_hostname = UrlParser::getPartValueFromUrl($url, "hostname");
        $origin_hostname = UrlParser::getPartValueFromUrl($origin, "hostname");

        if (!$url_hostname || !$origin_hostname) {
            return false;
        }

        return Assert::same((string) $url_hostname, (string) $origin_hostname);
    }
}
