<?php

namespace Ismaxim\Urling\Core\Utilities\PartParsers\Registrars;

use Ismaxim\Urling\PartParsers\SchemeParser;
use Ismaxim\Urling\PartParsers\HostParser;
use Ismaxim\Urling\PartParsers\PortParser;
use Ismaxim\Urling\PartParsers\UserParser;
use Ismaxim\Urling\PartParsers\PassParser;
use Ismaxim\Urling\PartParsers\PathParser;
use Ismaxim\Urling\PartParsers\QueryParser;
use Ismaxim\Urling\PartParsers\FragmentParser;

trait ParsersRegistrar
{
    public SchemeParser   $scheme;
    public HostParser     $host;
    public PortParser     $port;
    public UserParser     $user;
    public PassParser     $pass;
    public PathParser     $path;
    public QueryParser    $query;
    public FragmentParser $fragment;

    private function registerParsers() : void
    {
        $this->scheme   = new SchemeParser();
        $this->host     = new HostParser();
        $this->port     = new PortParser();
        $this->user     = new UserParser();
        $this->pass     = new PassParser();
        $this->path     = new PathParser();
        $this->query    = new QueryParser();
        $this->fragment = new FragmentParser();

        $this->addParts($this->origin);
    }
}