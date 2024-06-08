<?php

namespace App\Middleware;

class Register
{

    // This is global middleware
    const webMiddleware = [
//        "cors" => Cors::class,
    ];

    // This middleware only for web route
    const middlewareGroup = [
        "authAPI" => APIAuth::class,
        "auth" => Auth::class,
        "isLogin" => RedirectIfAuthenticate::class,
        "cors" => Cors::class,
        "can" => CheckPermission::class,
    ];

    public static function resolve($keys)
    {
        if (count($keys) > 0) {

            foreach ($keys as $key) {
                $middlewareName = $key;
                $param = "";

                $text = explode(":", $key);
                if (count($text) > 0) {
                    if (isset($text[0])) {
                        $middlewareName = $text[0];
                    }
                    if (isset($text[1])) {
                        $param = $text[1];
                    }
                }

                $middleware = static::middlewareGroup[$middlewareName] ? static::middlewareGroup[$middlewareName] : false;

                if (!$middleware) {
                    throw new \Exception("No matching middleware found for key '{$middlewareName}'.");
                }

                new $middleware($param);
            }
        }
    }

    public function middlewareForWeb()
    {
        $middlewares = static::webMiddleware;
        if ($middlewares) {
            foreach ($middlewares as $middleware) {
                new $middleware();
            }
        }
    }


}
