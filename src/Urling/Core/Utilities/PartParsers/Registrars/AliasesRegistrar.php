<?php

namespace Urling\Core\Utilities\PartParsers\Registrars;

use Urling\PartParsers\SchemeParser;
use Urling\PartParsers\HostParser;
use Urling\PartParsers\UserParser;
use Urling\PartParsers\PassParser;
use Urling\PartParsers\PathParser;
use Urling\PartParsers\QueryParser;
use Urling\PartParsers\FragmentParser;
use Urling\PartParsers\PortParser;

trait AliasesRegistrar
{
    public SchemeParser $protocol;
    public HostParser $hostname;
    public HostParser $domain;
    public UserParser $username;
    public PassParser $password;
    public PathParser $routes;
    public QueryParser $params;
    public QueryParser $attributes;
    public FragmentParser $anchor;

    private function registerAliases(): void
    {
        $this->protocol   = $this->scheme;
        $this->hostname   = $this->host;
        $this->domain     = $this->host;
        $this->username   = $this->user;
        $this->password   = $this->pass;
        $this->routes     = $this->path;
        $this->params     = $this->query;
        $this->attributes = $this->query;
        $this->anchor     = $this->fragment;
    }
}
