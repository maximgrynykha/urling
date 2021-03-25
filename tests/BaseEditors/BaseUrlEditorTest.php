<?php

namespace Urling\Tests\BaseEditors;

use Urling\Tests\BaseTest;
use Urling\Core\Exceptions\EditException;

final class BaseUrlEditorTest extends BaseTest
{
    /**
     * @return void
     */
    public function testAddUrl(): void
    {
        $new_url_to_add = "https://www.apple.com/iphone/";

        // Delete currently existing url set by default (<delete> test passes below)
        $this->urling->url->delete();

        $this->assertSame($new_url_to_add, $this->urling->url->add($new_url_to_add));
    }

    /**
     * @return void
     */
    public function testGetUrl(): void
    {
        $this->assertSame($this->base_url, $this->urling->url->get());
    }

    /**
     * @return void
     */
    public function testUpdateUrl(): void
    {
        $new_url_to_update = "https://www.microsoft.com/en-us/windows/";

        $this->assertSame($new_url_to_update, $this->urling->url->update($new_url_to_update));
    }

    /**
     * @return void
     */
    public function testDeleteUrl(): void
    {
        $this->assertSame(null, $this->urling->url->delete());
    }

    /**
     * @return void
     */
    public function testAddUrlException(): void
    {
        $this->expectException(EditException::class);
        $this->urling->url->add("https://www.microsoft.com/en-us/windows");
    }
}
