<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', dirname(__FILE__));
define('DIR_IMG', 'public' . DS . 'img' . DS);

error_reporting(E_ALL);

if (getenv('ENVIRONMENT') == 'PROD') {
    
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'php-log-' . date('Y-m-d') . '.txt');

} else {
    ini_set('display_errors', 1);
    ini_set('log_errors', 0);
}

if (!function_exists('base_url')) {

    function base_url($url = '', $full = false) {

        $base_url = '';
        
        if ((isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false)) {
            $base_url .= dirname($_SERVER['SCRIPT_NAME']);
        }

        if (($full || getenv('ENVIRONMENT') == 'DOCKER') && isset($_SERVER['SERVER_NAME'])) {

            $base_url = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
            $base_url .= $_SERVER['SERVER_NAME'];
            if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
                $base_url .= ':' . $_SERVER['SERVER_PORT'];
            }
        }
        
        return $base_url . $url;
    }

}

if (!function_exists('debug')) {

    function debug($var) {
        $template = PHP_SAPI !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
        printf($template, print_r($var, true));
    }

}

if (!function_exists('write_log')) {

    function write_log($msg) {

        $filepath = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'log-' . date('Y-m-d') . '.txt';
        $message = '';

        $date = date('Y-m-d H:i:s ');

        $message .= $date;
        $message .= $msg;

        $fp = @fopen($filepath, 'a+');
        fwrite($fp, $message . PHP_EOL);
        fclose($fp);
    }

}

if (!function_exists('array_get')) {

    function array_get(array $data, $path, $default = null) {
        if (empty($data) || $path === null) {
            return $default;
        }
        if (is_string($path) || is_numeric($path)) {
            $parts = explode('.', $path);
        } elseif (is_bool($path) || $path === null) {
            $parts = array($path);
        } else {
            if (!is_array($path)) {
                return 'error';
            }
            $parts = $path;
        }

        foreach ($parts as $key) {
            if (is_array($data) && isset($data[$key])) {
                $data = & $data[$key];
            } else {
                return $default;
            }
        }

        return $data;
    }

}

function process_error_message($errors = []) {
    $errorMessage = '';
    foreach ($errors as $error => $messages) {
        foreach ($messages as $message) {
            $errorMessage .= ' - ' . $message . '<br>';
        }
    }

    create_flash_message($errorMessage, 'danger');
}

function create_flash_message(string $message, string $type): void {
    $_SESSION['FLASH_MESSAGES'][] = ['message' => $message, 'type' => $type];
}

function format_flash_message(array $flash_message): string {
    return sprintf("<div class='alert alert-%s'>%s</div>",
            array_get($flash_message, 'type', 'info'),
            array_get($flash_message, 'message', '-'),
    );
}

function display_flash_message(): void {
    if (!isset($_SESSION['FLASH_MESSAGES'])) {
        return;
    }

    foreach ($_SESSION['FLASH_MESSAGES'] as $messageKey => $message) {
        echo format_flash_message($message);
        unset($_SESSION['FLASH_MESSAGES'][$messageKey]);
    }
}

if (!function_exists('apache_request_headers')) {


    function apache_request_headers() {
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == "HTTP_") {
                $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
                $out[$key] = $value;
            } else {
                $out[$key] = $value;
            }
        }
        return $out;
    }

} 