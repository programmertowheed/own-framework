<?php

namespace System\redirect;

class Redirect
{
    public function __construct()
    {
    }

    public function route($path, $params = [])
    {
        $queryString = "";
        if ($params) {
            $numItems = count($params);
            $i = 0;
            $queryString .= "?";
            foreach ($params as $key => $value) {
                if (++$i === $numItems) {
                    $queryString .= $key . "=" . $value;
                } else {
                    $queryString .= $key . "=" . $value . "&";
                }
            }
        }
        $path = ltrim($path, '/');
        $url = BASE_URL . "/" . $path;
        session_start();
        $_SESSION["route_params"] = $params;
        header("Location: $url");
        die();
    }

    public function view($filename = '', $data = false)
    {
        if ($data == true) {
            extract($data);
        }
        $filename = str_replace(".", "/", $filename);

        include BASE_PATH . "app/views/" . $filename . ".php";
    }

}