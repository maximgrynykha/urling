<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class FragmentParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->fragment->exists());
    }
}
