<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class PathParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->path->exists());
    }

    /**
     * @return void
     */
    public function testExplode(): void
    {
        $this->assertEqualsCanonicalizing(
            ["ismaxim", "urling"],
            $this->urling->url->path->explode()
        );
    }
}