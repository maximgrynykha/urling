<?php

namespace Ismaxim\Urling\PartParsers;

use Ismaxim\Urling\Core\Utilities\Misc\LogicVerifier;

final class PathParser extends URLPartParser
{
    // code here

    /**
     * Универасальная функция для isRouteExist / isRoutesExists  
     * Examples:  
     * - $urling->url->routes->exist("ismaxim");  
     * - $urling->url->routes->exist(["ismaxim", "urling"]);
     * 
     * @param string|array|null $params
     * 
     * @return bool
     */
    public function exists($routes = null) : bool
    {
        if (!isset($routes)) {
            return parent::exists();
        }

        if (is_array($routes) && count($routes)) {
            // 
        } elseif(is_string($routes) && mb_strlen($routes)) {
            // 
        }
    }
    
    public function explode() : ?array 
    {
        $routes_string = $this->value;

        if (LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($routes_string))) {
            if (mb_strpos($routes_string, "/") !== false) {
                $routes = explode("/", $routes_string);
                $routes = array_filter($routes, function (string $route) {
                    return LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($route));
                });
            } else $routes = [$routes_string];
        }

        return $routes ?? null;
    }

    // $url_parser->routes->addRoute();
    // $url_parser->routes->getRoute();
    // $url_parser->routes->updateRoute();
    // $url_parser->routes->deleteRoute();

    // $url_parser->routes->addRoute("route_value");
    // $url_parser->routes->getRoute(3);
    // $url_parser->routes->updateRoute(3, "route_value");
    // $url_parser->routes->deleteRoute(3);

    // $url_parser->routes->addRouteBetween("route_value", $start = 1, $end = 3);
    // $url_parser->routes->getRouteBetween($start = 1, $end = 3);
    // $url_parser->routes->updateRouteBetween("route_value", $start = 1, $end = 3);
    // $url_parser->routes->deleteRouteBetween($start = 1, $end = 3);

   /*  public function getFileRoute() : ?string
    {
        $routes = $this->getRoutesArray();

        $file_route = array_filter($routes, function (string $route) {
            return count(explode(".", $route)) === 2;
        });

        return $file_route[array_keys($file_route)[0] ?? null] ?? null;
    } */
}