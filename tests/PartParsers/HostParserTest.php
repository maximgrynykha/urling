<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class HostParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->host->exists());
    }
}