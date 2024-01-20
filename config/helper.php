<?php

/**
 * @param $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('sendResponse')) {
    function sendResponse($message = '', $data = [], $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message
        ];

        !empty($data) ? $response['data'] = $data : null;

        return response()->json($response, $code);
    }
}


/**
 * @param $message
 * @param array $messages
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('sendError')) {
    function sendError($message = '', $errors = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message
        ];

        !empty($errors) ? $response['errors'] = $errors : null;

        return response()->error($response, $code);
    }
}


/**
 * server error response function
 *
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('serverError')) {
    function serverError()
    {
        return response()->serverError();
    }
}


/**
 * Generate random number function
 *
 * @param integer $length
 * @return void
 */
if (!function_exists('randomString')) {
    function randomString($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}

if (!function_exists('public_path')) {
    function public_path()
    {
        return BASE_PATH . "public";
    }
}

if (!function_exists('assets')) {
    function assets($path)
    {
        return BASE_PATH . "public" . $path;
    }
}


if (!function_exists('url')) {
    function url($path)
    {
        return BASE_URL . $path;
    }
}


if (!function_exists('includes')) {
    function includes($filename, $data = [])
    {
        if (!is_array($data)) {
            response()->viewError("404", "Your data should be an array!");
        }
        extract($data);
        $filename = str_replace(".", "/", $filename);
        include BASE_PATH . "app/views/" . $filename . ".php";
    }
}