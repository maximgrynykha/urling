<?php

namespace Urling\PartParsers;

use Urling\Core\Part;

final class PathParser extends Part
{
    // code here

    /**
     * $urling->routes->contains("route_name");
     * $urling->routes->contains(["route_name_1", "route_name_1"]);
     * 
     * @param array<int, string>|string $needle
     *
     * @return bool
     */
    public function contains($needle): bool
    {
        if (!$this->value || !$needle) {
            return false;
        }

        $is_contains = false;

        if (is_array($needle)) {
            $is_contains = $this->containRoutes($needle);
        } elseif (is_string($needle) && mb_strlen($needle)) {
            $is_contains = $this->containRoute($needle);
        }

        return $is_contains;
    }

    /**
     * @return array<string, string|null>|array<int, string|null>|null
     */
    public function explode(): ?array
    {
        $routes_string = $this->value;

        if ($routes_string) {
            if (mb_strpos($routes_string, "/") !== false) {
                $routes = explode("/", $routes_string);
                $routes = array_filter($routes, function (string $route) {
                    return $route == true;
                });
            } else {
                $routes = [$routes_string];
            }
        }

        return $routes ?? null;
    }

    /**
     * @param array<int, string> $routes
     * 
     * @return bool
     */
    private function containRoutes(array $routes): bool
    {        
        foreach ($routes as $route) {
            if (!($this->containRoute($route))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $route
     * 
     * @return bool
     */
    private function containRoute(string $route): bool
    {
        $routes = $this->explode();

        return in_array($route, (array) $routes);
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
