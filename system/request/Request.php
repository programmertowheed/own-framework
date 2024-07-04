<?php

namespace System\request;

class Request
{
    public function __construct()
    {
        $this->serverRequest();
    }

    public function serverRequest()
    {
        $uaer_data = getCookie(USER_COOKIE_NAME);

        $data = [];
        $data['ip'] = $this->get_client_ip();

        if (isset($uaer_data) && $uaer_data->user_id) {
            $data['auth'] = $uaer_data;
        }

        $json = json_decode(file_get_contents('php://input'), true) ? json_decode(file_get_contents('php://input'), true) : [];
        $post = $_POST ? $_POST : [];

        $data = array_merge($data, $json, $post);
        return (object)$data ? (object)$data : [];
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}