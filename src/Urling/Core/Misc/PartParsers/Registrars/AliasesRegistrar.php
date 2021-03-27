<?php

namespace Urling\Core\Misc\PartParsers\Registrars;

use Urling\PartParsers\SchemeParser;
use Urling\PartParsers\UserParser;
use Urling\PartParsers\PassParser;
use Urling\PartParsers\HostParser;
use Urling\PartParsers\PortParser;
use Urling\PartParsers\PathParser;
use Urling\PartParsers\QueryParser;
use Urling\PartParsers\FragmentParser;

trait AliasesRegistrar
{
    public SchemeParser $protocol;
    public UserParser $username;
    public PassParser $password;
    public HostParser $hostname;
    public HostParser $domain;
    public PathParser $routes;
    public QueryParser $params;
    public QueryParser $attributes;
    public FragmentParser $anchor;

    private function registerAliases(): void
    {
        $this->protocol   = $this->scheme;
        $this->username   = $this->user;
        $this->password   = $this->pass;
        $this->hostname   = $this->host;
        $this->domain     = $this->host;
        $this->routes     = $this->path;
        $this->params     = $this->query;
        $this->attributes = $this->query;
        $this->anchor     = $this->fragment;
    }
}
