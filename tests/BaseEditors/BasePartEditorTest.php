<?php

namespace Urling\Tests\BaseEditors;

use Urling\Tests\BaseTest;
use Urling\Core\Exceptions\EditException;

final class BasePartEditorTest extends BaseTest
{
    // public function urlsProvider(): array
    // {
    //     return [
    //         ["https://github.com/ismaxim/urling"],
    //         ["https://github.com/laravel/laravel"],
    //     ];
    // }

    // ------------------------------------------------------------------
    // SCHEME tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetScheme(): void
    {
        $this->assertSame("https", $this->urling->url->scheme->get());
    }

    /**
     * @return void
     */
    public function testAddScheme(): void
    {
        // Delete currently existing 'scheme' set in default URL (<delete> test passes below)
        $this->urling->url->scheme->delete();

        $new_scheme = "ftp";

        $this->assertSame($new_scheme, $this->urling->url->scheme->add($new_scheme));
    }

    /**
     * @return void
     */
    public function testUpdateScheme(): void
    {
        $new_scheme = "smtp";

        $this->assertSame($new_scheme, $this->urling->url->scheme->update($new_scheme));
    }

    /**
     * @return void
     */
    public function testDeleteScheme(): void
    {
        $this->assertSame(null, $this->urling->url->scheme->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // USER tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetUser(): void
    {
        $this->assertSame("ismaxim", $this->urling->url->user->get());
    }

    /**
     * @return void
     */
    public function testAddUser(): void
    {
        // Delete currently existing 'user' set in default URL (<delete> test passes below)
        $this->urling->url->user->delete();

        $new_user = "janewhite";

        $this->assertSame($new_user, $this->urling->url->user->add($new_user));
    }

    /**
     * @return void
     */
    public function testUpdateUser(): void
    {
        $new_user = "johnsmith";

        $this->assertSame($new_user, $this->urling->url->user->update($new_user));
    }

    /**
     * @return void
     */
    public function testDeleteUser(): void
    {
        $this->assertSame(null, $this->urling->url->user->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // PASS tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetPass(): void
    {
        $this->assertSame("12345", $this->urling->url->pass->get());
    }

    /**
     * @return void
     */
    public function testAddPass(): void
    {
        // Delete currently existing 'pass' set in default URL (<delete> test passes below)
        $this->urling->url->pass->delete();

        $new_pass = "67890";

        $this->assertSame($new_pass, $this->urling->url->pass->add($new_pass));
    }

    /**
     * @return void
     */
    public function testUpdatePass(): void
    {
        $new_pass = "124579";

        $this->assertSame($new_pass, $this->urling->url->pass->update($new_pass));
    }

    /**
     * @return void
     */
    public function testDeletePass(): void
    {
        $this->assertSame(null, $this->urling->url->pass->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // HOST tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetHost(): void
    {
        $this->assertSame("github.com", $this->urling->url->host->get());
    }

    /**
     * @return void
     */
    public function testAddHost(): void
    {
        // Delete currently existing 'host' set in default URL (<delete> test passes below)
        $this->urling->url->host->delete();

        $new_host = "apple.com";

        $this->assertSame($new_host, $this->urling->url->host->add($new_host));
    }

    /**
     * @return void
     */
    public function testUpdateHost(): void
    {
        $new_host = "microsoft.com";

        $this->assertSame($new_host, $this->urling->url->host->update($new_host));
    }

    /**
     * @return void
     */
    public function testDeleteHost(): void
    {
        $this->assertSame(null, $this->urling->url->host->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // PORT tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetPort(): void
    {
        $this->assertSame("443", $this->urling->url->port->get());
    }

    /**
     * @return void
     */
    public function testAddPort(): void
    {
        // Delete currently existing 'port' set in default URL (<delete> test passes below)
        $this->urling->url->port->delete();

        $new_port = "3000";

        $this->assertSame($new_port, $this->urling->url->port->add($new_port));
    }

    /**
     * @return void
     */
    public function testUpdatePort(): void
    {
        $new_port = "8080";

        $this->assertSame($new_port, $this->urling->url->port->update($new_port));
    }

    /**
     * @return void
     */
    public function testDeletePort(): void
    {
        $this->assertSame(null, $this->urling->url->port->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // PATH tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetPath(): void
    {
        $this->assertSame("ismaxim/urling", $this->urling->url->path->get());
    }

    /**
     * @return void
     */
    public function testAddPath(): void
    {
        // Delete currently existing 'path' set in default URL (<delete> test passes below)
        $this->urling->url->path->delete();

        $new_path = "shop/buy-iphone/iphone-12-pro";

        $this->assertSame($new_path, $this->urling->url->path->add($new_path));
    }

    /**
     * @return void
     */
    public function testUpdatePath(): void
    {
        $new_path = "en-us/windows";

        $this->assertSame($new_path, $this->urling->url->path->update($new_path));
    }

    /**
     * @return void
     */
    public function testDeletePath(): void
    {
        $this->assertSame(null, $this->urling->url->path->delete());
    }
    // ------------------------------------------------------------------

    
    // ------------------------------------------------------------------
    // QUERY tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetQuery(): void
    {
        $this->assertSame("username=ismaxim&repository=urling", $this->urling->url->query->get());
    }

    /**
     * @return void
     */
    public function testAddQuery(): void
    {
        // Delete currently existing 'query' set in default URL (<delete> test passes below)
        $this->urling->url->query->delete();

        $new_query = "apple-product=iphone";

        $this->assertSame($new_query, $this->urling->url->query->add($new_query));
    }

    /**
     * @return void
     */
    public function testUpdateQuery(): void
    {
        $new_query = "microsoft-product=windows";

        $this->assertSame($new_query, $this->urling->url->query->update($new_query));
    }

    /**
     * @return void
     */
    public function testDeleteQuery(): void
    {
        $this->assertSame(null, $this->urling->url->query->delete());
    }
    // ------------------------------------------------------------------


    // ------------------------------------------------------------------
    // FRAGMENT tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testGetFragment(): void
    {
        $this->assertSame("installation", $this->urling->url->fragment->get());
    }

    /**
     * @return void
     */
    public function testAddFragment(): void
    {
        // Delete currently existing 'fragment' set in default URL (<delete> test passes below)
        $this->urling->url->fragment->delete();

        $new_fragment = "usage";

        $this->assertSame($new_fragment, $this->urling->url->fragment->add($new_fragment));
    }

    /**
     * @return void
     */
    public function testUpdateFragment(): void
    {
        $new_fragment = "testing";

        $this->assertSame($new_fragment, $this->urling->url->fragment->update($new_fragment));
    }

    /**
     * @return void
     */
    public function testDeleteFragment(): void
    {
        $this->assertSame(null, $this->urling->url->fragment->delete());
    }
    // ------------------------------------------------------------------

    
    // ------------------------------------------------------------------
    // Exceptions tests
    // ------------------------------------------------------------------

    /**
     * @return void
     */
    public function testAddSchemeException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'scheme' set in default URL (<delete> test passes above)
        $this->urling->url->scheme->delete();
        $this->urling->url->scheme->add("https");
        
        $this->urling->url->scheme->add("https");
    }

    /**
     * @return void
     */
    public function testAddUserException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'user' set in default URL (<delete> test passes above)
        $this->urling->url->user->delete();
        $this->urling->url->user->add("ismaxim");
        
        $this->urling->url->user->add("ismaxim");
    }

    /**
     * @return void
     */
    public function testAddPassException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'pass' set in default URL (<delete> test passes above)
        $this->urling->url->pass->delete();
        $this->urling->url->pass->add("12345");
                
        $this->urling->url->pass->add("12345");
    }

    /**
     * @return void
     */
    public function testAddHostException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'host' set in default URL (<delete> test passes above)
        $this->urling->url->host->delete();
        $this->urling->url->host->add("github.com");
                    
        $this->urling->url->host->add("giithub.com");
    }

    /**
     * @return void
     */
    public function testAddPortException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'port' set in default URL (<delete> test passes above)
        $this->urling->url->port->delete();
        $this->urling->url->port->add("443");
                            
        $this->urling->url->port->add("443");
    }

    /**
     * @return void
     */
    public function testAddPathException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'path' set in default URL (<delete> test passes above)
        $this->urling->url->path->delete();
        $this->urling->url->path->add("ismaxim/urling");
                            
        $this->urling->url->path->add("ismaxim/urling");
    }
    
    /**
     * @return void
     */
    public function testAddQueryException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'query' set in default URL (<delete> test passes above)
        $this->urling->url->query->delete();
        $this->urling->url->query->add("username=ismaxim&repository=urling");
                            
        $this->urling->url->query->add("username=ismaxim&repository=urling");
    }

    /**
     * @return void
     */
    public function testAddFragmentException(): void
    {
        $this->expectException(EditException::class);

        // Delete currently existing 'query' set in default URL (<delete> test passes above)
        $this->urling->url->fragment->delete();
        $this->urling->url->fragment->add("username=ismaxim&repository=urling");
                            
        $this->urling->url->fragment->add("username=ismaxim&repository=urling");
    }
}