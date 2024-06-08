<?php

namespace System\response;

class Response
{
    public function __construct()
    {
        header("Content-type: application/json");
    }

    public function json(array $content = [], $status = 200)
    {
        $content["status_code"] = $status;
        http_response_code($status);
        echo json_encode($content);
        exit();
    }

    public function success(array $content = [], $status = 200)
    {
        $content["status_code"] = $status;
        http_response_code($status);
        echo json_encode($content);
        exit();
    }

    public function error(array $content = [], $status = 404)
    {
        $content["status_code"] = $status;
        http_response_code($status);
        echo json_encode($content);
        exit();
    }

    public function abort()
    {
        $content["message"] = "Permission denied";
        $content["status_code"] = 403;
        http_response_code(403);
        echo json_encode($content);
        exit();
    }

    public function serverError()
    {
        $content["message"] = "Internal server error";
        $content["status_code"] = 500;
        http_response_code(500);
        echo json_encode($content);
        exit();
    }

    public function viewError($filename, $msssage = null)
    {
        if (!is_null($msssage)) {
            $msg = $msssage;
        }
        error_reporting(0);
        header("Content-type: text/html; charset=UTF-8");
        include_once BASE_PATH . "system/view/error/" . $filename . ".php";
        exit();
    }

}