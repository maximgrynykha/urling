<?php

namespace Ismaxim\Urling\Core\Utilities\PartParsers\Registrars;

use Ismaxim\Urling\PartParsers\SchemeParser;
use Ismaxim\Urling\PartParsers\HostParser;
use Ismaxim\Urling\PartParsers\UserParser;
use Ismaxim\Urling\PartParsers\PassParser;
use Ismaxim\Urling\PartParsers\PathParser;
use Ismaxim\Urling\PartParsers\QueryParser;
use Ismaxim\Urling\PartParsers\FragmentParser;
use Ismaxim\Urling\PartParsers\PortParser;

trait AliasesRegistrar 
{
    public SchemeParser   $protocol;
    public HostParser     $hostname;
    public HostParser     $domain;
    public UserParser     $username;
    public PassParser     $password;
    public PathParser     $routes;
    public QueryParser    $params;
    public QueryParser    $attributes;
    public FragmentParser $anchor;

    private function registerAliases() : void
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