<?php

namespace System\route;

use App\Middleware\Register;

/**
 * Base Route Controller
 */
class Base
{

    private static $instance;

    private static $routes = [];

    private static $parameters = [];

    /**
     * Returns the instance of the class.
     * @return Base
     */
    private static function getInstance()
    {
        // Create it if it doesn't exist.
        if (!self::$instance) {
            self::$instance = new Base();
        }
        return self::$instance;
    }

    private static function routePush($path, $controller, $method)
    {
        self::$routes[] = [
            "path" => $path,
            "controller" => $controller,
            "method" => $method,
            "middleware" => []
        ];
        return self::getInstance();
    }

    private static function getMethod()
    {
        $method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];
        $method = strtoupper($method);

        if (!in_array($method, METHOD_ARRAY)) {
            sendError("Route method not allow!");
            exit();
        }

        return $method;
    }

    private static function getURI()
    {
        $url = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "/";
        $url = $url !== "" ? $url : "/";

        if (!is_null($url) && $url !== "/") {
            $url = rtrim($url, '/');
        }
        return $url;
    }

    private static function checkMethod($method)
    {
        $request_method = self::getMethod();
        $method = strtoupper($method);

        // Check method
        if ($method == $request_method) {
            return true;
        }
        return false;
    }

    private static function checkPath($path)
    {
        if ($path !== "/") {
            $path = ltrim($path, '/');
        }

        // Check path
        if (is_null($path) || empty($path)) {
            sendError("Route path empty!");
            exit();
        }

        $url = self::getURI();

        $status = false;

        // Check method
        if ($url === $path) {
            $status = true;
        } else {
            $status = self::pathMatch($url, $path);
        }

        return $status;
    }

    private static function pathMatch($url, $path)
    {
        $status = false;
        $urls = explode("/", $url);
        $paths = explode("/", $path);

        $url_count = count($urls);
        $path_count = count($paths);
        $path_count_less = count($paths);

        if ($url_count > 0 && $path_count && $url_count <= $path_count) {
            foreach ($paths as $key => $value) {
                if (str_starts_with($value, '{') && str_ends_with($value, '}') && substr("$value", -2) === "?}") {
                    $path_count_less -= 1;
                    if (array_key_exists($key, $urls)) {
                        $value = str_replace("{", "", $value);
                        $value = str_replace("?}", "", $value);
                        self::$parameters[$value] = $urls[$key];
                    }
                    $status = true;
                } elseif (str_starts_with($value, '{') && str_ends_with($value, '}')) {
                    if (array_key_exists($key, $urls)) {
                        $value = str_replace("{", "", $value);
                        $value = str_replace("}", "", $value);
                        self::$parameters[$value] = $urls[$key];
                    }
                    $status = true;
                } else {
                    if (array_key_exists($key, $urls) && $urls[$key] === $value) {
                        $status = true;
                    } else {
                        return false;
                    }
                }
            }

            if ($url_count <= $path_count && $url_count >= $path_count_less) {
                return $status;
            } else {
                return false;
            }

        }

        return $status;
    }

    private static function checkValidation($controller)
    {
        if (count($controller) < 2) {
            sendError("Route controller or method is empty");
            exit();
        }
    }


    public static function callController($controller)
    {
        $method = (string)$controller[1];
        $ctrl = new $controller[0]();
        $ctrl->$method(self::$parameters);
    }


    public static function get($path, $controller)
    {
        return self::routePush($path, $controller, "GET");
    }

    public static function post($path, $controller = [])
    {
        return self::routePush($path, $controller, "POST");
    }

    public static function put($path, $controller = [])
    {
        return self::routePush($path, $controller, "PUT");
    }

    public static function patch($path, $controller = [])
    {
        return self::routePush($path, $controller, "PATCH");
    }

    public static function delete($path, $controller = [])
    {
        return self::routePush($path, $controller, "DELETE");
    }

    public static function route()
    {
        foreach (self::$routes as $route) {
            if (self::checkMethod($route["method"]) && self::checkPath($route["path"])) {
                Register::resolve($route["middleware"]);
                if (is_callable($route["controller"])) {
                    call_user_func($route["controller"]);
                    exit();
                }
                if (is_array($route["controller"])) {
                    self::checkValidation($route["controller"]);
                    self::callController($route["controller"]);
                    exit();
                }
            }
        }

        sendError("Route not found!");
        die();
    }

    public function middleware($keys = [])
    {
        foreach ($keys as $key) {
            self::$routes[array_key_last(self::$routes)]["middleware"][] = $key;
        }
    }

    public static function groupMiddleware(array $middlewares, $function)
    {
        if (count($middlewares) <= 0) {
            throw new \Exception("Middleware array should not be empty! in ");
        }
        $lastKey = array_key_last(self::$routes);
        if ($lastKey && $lastKey > 0) {
            $lastKey += 1;
        } else {
            if ($lastKey === 0) {
                $lastKey = 1;
            } else {
                $lastKey = 0;
            }
        }
        call_user_func($function);
        $endKey = array_key_last(self::$routes);

        for ($i = $lastKey; $i <= $endKey; $i++) {
            foreach ($middlewares as $key) {
                self::$routes[$i]["middleware"][] = $key;
            }
        }
    }


}




