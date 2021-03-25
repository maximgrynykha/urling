<?php

namespace Urling\Tests;

use PHPUnit\Framework\TestCase;
use Throwable;
use Urling\Tests\TestHelpers\BaseUrl;
use Urling\Urling;

abstract class BaseTest extends TestCase
{
    use BaseUrl;

    protected Urling $urling;
    protected string $base_url;

    /**
     * Данный метод ничего не возращает и вызывается 
     * перед всеми методами текущего класса.
     * 
     * Вызываеться при создании объекта текущего класса, единажды.
     * 
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        // fwrite(STDOUT, __METHOD__."\n");
    }

    /**
     * Данный метод вызыватся для каждого теста в текущем классе.
     * Отвечает за базовою настройку тестового окружения.
     * 
     * Похож на метод __construct()
     * 
     * @return void
     */
    protected function setUp(): void    
    {
        $this->base_url = $this->getBaseUrl();
        $this->urling = new Urling($this->base_url);
    }

    /**
     * Вызываеться перед тестирование конкретных значений
     * используемых методами assert()
     * 
     * Данный метод вызыватся для каждого теста в текущем классе.
     * 
     * @return void
     */
    protected function assertPreConditions(): void
    {
        // code here
        // fwrite(STDOUT, __METHOD__."\n");
    }

    // -----------------------------------------------------------
    // далее идут тесты...
    // -----------------------------------------------------------

    /**
     * Вызываеться после отработки тестов с использование методов assert()
     * 
     * Если тест провалился тогда этот метод не вызывается для теста
     * 
     * @return void
     */
    protected function assertPostConditions(): void
    {
        // code here
        // fwrite(STDOUT, __METHOD__."\n");
    }

    /**
     * Вызываеться после отработки конкретного теста.
     * Используеться для очистки памяти
     * 
     * Похож на метод __destruct()
     * 
     * @return void
     */
    protected function tearDown(): void
    {
        // code here
        // fwrite(STDOUT, __METHOD__."\n");
    }

    /**
     * Вызываеться при провальном завершении конкретного теста
     * 
     * @param Throwable $t
     * 
     * @return void
     */
    protected function onNotSuccessfulTest(Throwable $t): void
    {
        parent::onNotSuccessfulTest($t);
        // fwrite(STDOUT, __METHOD__."\n");
    }

    /**
     * Вызываеться после отработки всех тестов в конкретном классе.
     * 
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        // code here
        // fwrite(STDOUT, __METHOD__."\n");

        /* // ---------------------- Parser -----------------------
        
        $urling = new Urling("https://github.com/ismaxim/urling#installation");

        $url_part_values = [
            "protocol_value" => $urling->url->protocol->get(),
            "domain_value"   => $urling->url->domain->get(),
            "routes_value"   => $urling->url->routes->get(),
            "anchor_value"   => $urling->url->anchor->get(),
        ];

        // -----------------------------------------------------
        // RESULT: 
        // [
        //      "protocol_value" => "https",
        //      "domain_value" => "github.com",
        //      "routes_value" => "ismaxim/urling",
        //      "anchor_value" => "#installation",
        // ]
        // -----------------------------------------------------

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        // -------------------- Constructor --------------------
        
        $urling = new Urling();

        $urling->url->construct([
            "protocol" => "https",
            "domain"   => "github.com",
            "routes"   => "/ismaxim/urling",
            "anchor"   => "#installation",
        ]);

        // !! or you can set a value for each distinct part 
        // in the url by accessing it directly, for example:

        $urling->url->protocol->add("https");
        $urling->url->domain->add("github.com");
        $urling->url->routes->add("/ismaxim/urling");
        $urling->url->anchor->add("#installation");

        // -----------------------------------------------------
        // RESULT: https://github.com/ismaxim/urling#installtion
        // ----------------------------------------------------- 
        
        👋 If you got a task that doesn't can be solved with this library, 
        please write your own solution, and if you wish to help others 🤝
        who use this library also (or wants to save your solution workable 
        after the new release will arrive at your dependencies) make a pull-request. 
        We will happy to add your brilliant💎 code to the library🚀!

        🤝👋⚡️🔥✨🎯🚥🚀💎

        */
    }
}