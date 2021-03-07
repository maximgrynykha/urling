<?php

namespace Ismaxim\Urling\PartParsers;

use Ismaxim\Urling\Core\Utilities\Editors\BasePartEditor;
use Ismaxim\Urling\Core\Utilities\Misc\IntelliExceptions\IntelliExceptions;
use Ismaxim\Urling\Core\Utilities\Misc\LogicVerifier;
use Ismaxim\Urling\Core\Utilities\PartParsers\Configurator;

abstract class URLPartParser
{
    use BasePartEditor;
    use IntelliExceptions;

    protected ?string $value;
    protected string $name;
    protected string $gluing;
    protected string $aliases;

    public function __construct()
    {
        $this->bootstrap();
    }

    protected function bootstrap() : void
    {
        $this->value   = null;
        $this->name    = Configurator::getName($this);
        $this->gluing  = Configurator::getGluing($this);
        $this->aliases = Configurator::getAliases($this);
    }

    public function exists() : bool
    {
        return LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($this->value));
    }

    // public function secure(string $value) : ?string
    // {
        // return htmlspecialchars(trim($value));
    // }


    // public function decode(string $url) : ?string 
    // {
    //     return urldecode($url);
    // }

    // public function encode(string $url) : ?string 
    // {
    //     return urlencode($url);
    // }

    # after implementation this function (last two above), need to add tags: 
    #   (php)*-url-decoder, (php)*-url-encoder; to lib-profile on GitHub



    /* 
        $url_parser->params->exist()

        isResourceHaveProtocol -> $url_parser->protocol->exist()
        isResourceHasPath      -> $url_parser->path->exist()
        isAnchorResource       -> $url_parser->anchor->exist()
        isAbsoluteResource     -> $url_parser->protocol->exist()
        createAnchor           -> $url_parser->anchor->get(true);
    */
}