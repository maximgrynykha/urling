<?php # declare(strict_types=1);

namespace Urling;

use Urling\Core\Url;

# Entry point
final class Urling
{
    public Url $url;

    public function __construct(string $url = null)
    {
        $this->url = new Url($url);
    }
}