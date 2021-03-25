<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class UserParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->user->exists());
    }
}