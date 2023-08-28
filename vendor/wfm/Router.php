<?php

namespace wfm;

use Exception;

class Router
{

    protected static array $routes = [];
    protected static array $route = [];

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$route;
    }

    protected static function removeQueryString($url)
    {
        if ($url) {
            //разбиваем строку на массив из 2-х элементов
            $params = explode('&', $url, 2);
            //if (false === self::contains($params[0], '=')) {
            if (false === str_contains($params[0], '=')) {
                return rtrim($params[0], '/');
            }
        }
        return '';
    }

    //если пхп 8 то лучше юзать str_contains
    //но если 8 пхп нет то вот я сделяль
    private static function contains(string $str, $symb): bool
    {
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] === $symb){
                return true;
            }
        }
        return false;
    }

    //этот метод вызывается из App
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' . self::$route['admin_prefix']
                . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new Exception('Страница не найдена', 404);
        }
    }

    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            // preg_match проверяет строку на соответствие выражению
            // ## это ограничители самого выражения, можно ещё использовать слеши или ~
            // флаг i нужен чтобы здесь regexp регистронезависимым
            if (preg_match("#{$pattern}#i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Преобразовывает строку с дефисами к CamelCase
     * new-product => NewProduct
     * @param $name входящая строка
     * @return string измененная строка
     */
    public static function upperCamelCase(string $name): string
    {
        // new-product => new product
        $name = str_replace('-', ' ', $name);
        // new product => New Product
        $name = ucwords($name);
        // New Product => NewProduct
        return str_replace(' ', '', $name);
    }

    /**
     * Преобразовывает CamelCase в lowerCamelCase
     * @param $name входящая строка
     * @return string измененная строка
     */
    public static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }
}