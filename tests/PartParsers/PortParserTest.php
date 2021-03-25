<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class PortParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->port->exists());
    }
}
