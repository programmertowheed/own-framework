<?php

namespace App\Middleware;

class Register
{

    public const webMiddleware = [
        "auth" => Auth::class,
    ];

    public const middlewareGroup = [
        "auth" => Auth::class,
    ];

    public static function resolve($keys)
    {
        if (count($keys) > 0) {

            foreach ($keys as $key) {
                $middleware = static::middlewareGroup[$key] ?? false;

                if (!$middleware) {
                    throw new \Exception("No matching middleware found for key '{$key}'.");
                }

                new $middleware();
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
