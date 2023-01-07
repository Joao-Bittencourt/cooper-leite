<?php

namespace core;

use CooperLeite\Config;

class Request {

    public static function getUrl() {
        $url = filter_input(INPUT_GET, 'request');
        $url = str_replace(Config::BASE_DIR, '', $url);
        $url = substr($url, 0,1) == '/' ? substr($url, 1) : $url;
        
        return '/' . $url;
    }
    
    public static function getData() {
        $data = $_POST;
        return $data;
    }

    public static function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}
