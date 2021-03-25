<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class PassParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->pass->exists());
    }
}
