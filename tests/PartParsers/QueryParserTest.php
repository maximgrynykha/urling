<?php

namespace Urling\Tests\PartEditors;

use Urling\Tests\BaseTest;

final class QueryParserTest extends BaseTest
{
    /**
     * @return void
     */
    public function testExists(): void
    {
        $this->assertTrue($this->urling->url->query->exists());
    }

    /**
     * @return void
     */
    public function testExplode(): void
    {
        $this->assertEqualsCanonicalizing(
            ["username=ismaxim", "repository=urling"],
            $this->urling->url->query->explode()
        );
    }

    /**
     * @return void
     */
    public function testGetNameValuePairs(): void
    {
        $this->assertEqualsCanonicalizing(
            ["username" => "ismaxim", "repository" => "urling"],
            $this->urling->url->query->getNameValuePairs()
        );
    }

    /**
     * @return void
     */
    public function testGetValueByName(): void
    {
        $this->assertSame("ismaxim", $this->urling->url->query->getValueByName("username"));
    }

    /**
     * @return void
     */
    public function testGetNameByValue(): void
    {
        $this->assertSame("username", $this->urling->url->query->getNameByValue("ismaxim"));
    }

    /**
     * @return void
     */
    public function testGetNames(): void
    {
        $this->assertEqualsCanonicalizing(
            ["username", "repository"],
            $this->urling->url->query->getNames()
        );
    }

    /**
     * @return void
     */
    public function testGetValues(): void
    {
        $this->assertEqualsCanonicalizing(
            ["ismaxim", "urling"],
            $this->urling->url->query->getValues()
        );
    }

    /**
     * @return void
     */
    public function testIsParamExist(): void
    {
        $this->assertTrue($this->urling->url->query->isParamExist("username"));
    }

    /**
     * @return void
     */
    public function testIsParamsExist(): void
    {
        $this->assertTrue($this->urling->url->query->isParamsExist(["username", "repository"]));
    }
}
