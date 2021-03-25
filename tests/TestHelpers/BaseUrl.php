<?php

namespace Urling\Tests\TestHelpers;

trait BaseUrl
{
    public function getBaseUrl(): string
    {
        $base_url_parts = [
            "scheme"   => "https://",
            "user"     => "ismaxim",
            "pass"     => ":12345@",
            "host"     => "github.com",
            "port"     => ":443",
            "path"     => "/ismaxim/urling",
            "query"    => "?username=ismaxim&repository=urling",
            "fragment" => "#installation",
        ];

        return implode("", $base_url_parts);
    }
}