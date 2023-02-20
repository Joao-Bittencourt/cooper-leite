<?php

namespace core;

use CooperLeite\Config;

class Request {

    public static function getUrl() {
        $url = filter_input(INPUT_GET, 'request');

        if (is_string($url)) {
            $url = str_replace(Config::BASE_DIR, '', $url);
            $url = substr($url, 0, 1) == '/' ? substr($url, 1) : $url;
        }

        return '/' . $url;
    }

    public static function getData() {
        $data = $_POST;
        return $data;
    }

    public static function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequestData() {

        switch (self::getMethod()) {
            case 'GET':
                return $_GET;

            case 'PUT':
//                $data = $this->parse_raw_http_request();
//                return $data;

            case 'DELETE':
            case 'POST':
                $data = json_decode(file_get_contents('php://input'));

                if (is_null($data)) {
                    $data = $_POST;
                }

                return (array) $data;
        }
    }

}
