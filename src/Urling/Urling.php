<?php

# declare(strict_types=1);

namespace Urling;

use Urling\Core\Url;
use Urling\Core\Misc\Tools\Tools;

# Entry point
final class Urling
{
    public Url $url;
    public Tools $tools;

    public function __construct(string $url = null)
    {
        $this->url = new Url($url);
        $this->tools = new Tools();
    }
}
