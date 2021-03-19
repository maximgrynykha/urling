<?php

namespace Urling\Core;

use Urling\Core\Utilities\Editors\BaseUrlEditor;
use Urling\Core\Utilities\Misc\IntelliExceptions\IntelliExceptions;
use Urling\Core\Utilities\Misc\LogicVerifier;
use Urling\Core\Utilities\Misc\SwissKnife;
use Urling\Core\Utilities\PartParsers\Registrars\AliasesRegistrar;
use Urling\Core\Utilities\PartParsers\Registrars\ParsersRegistrar;
use Urling\Core\Utilities\UrlParser;

final class Url
{
    use ParsersRegistrar;
    use AliasesRegistrar;
    use IntelliExceptions;
    use BaseUrlEditor;

    protected ?string $origin;

    public function __construct(string $url = null)
    {
        $this->origin = trim($url);
        $this->bootstrap();
    }

    protected function bootstrap(): void
    {
        $this->registerParsers();
        $this->registerAliases();
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
        $origin = $origin ?: $this->origin;

        if (! LogicVerifier::verify(fn () => LogicVerifier::isIssetAndNotEmpty($origin))) {
            return false;
        }

        if (($verify_protocols && ($url && $origin))) {
            $url_protocol = UrlParser::getPartValueFromUrl($url, 'protocol');
            $origin_protocol = UrlParser::getPartValueFromUrl($origin, 'protocol');

            if (! SwissKnife::isSameStrings($url_protocol, $origin_protocol)) {
                return false;
            }
        }

        $url_hostname = UrlParser::getPartValueFromUrl($url, 'hostname');
        $origin_hostname = UrlParser::getPartValueFromUrl($origin, 'hostname');

        if (
            ! LogicVerifier::verify(fn () => LogicVerifier::isIssetAndNotEmpty($url_hostname)) ||
            ! LogicVerifier::verify(fn () => LogicVerifier::isIssetAndNotEmpty($origin_hostname))
        ) {
            return false;
        }

        return SwissKnife::isSameStrings($url_hostname, $origin_hostname);
    }
}
