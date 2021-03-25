<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class SchemeParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->scheme->exists());
    }
}