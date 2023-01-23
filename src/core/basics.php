<?php

// @ToDo: revisar, verificar um local melhor para inicializar a sessão
//ini_set('session.save_handler','redis');
//ini_set('session.save_path','tcp://127.0.0.1:6379?prefix=cooper_leite_dev_');

session_start();

if (!function_exists('base_url')) {

    function base_url($url) {

        $base_url = '';
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $base_url .= dirname($_SERVER['SCRIPT_NAME']);
        }

        return $base_url . $url;
    }

}

if (!function_exists('h')) {

    function h($text, $double = true, $charset = null) {
        if (is_string($text)) {
            //optimize for strings
        } elseif (is_array($text)) {
            $texts = array();
            foreach ($text as $k => $t) {
                $texts[$k] = h($t, $double, $charset);
            }
            return $texts;
        } elseif (is_object($text)) {
            if (method_exists($text, '__toString')) {
                $text = (string) $text;
            } else {
                $text = '(object)' . get_class($text);
            }
        } elseif (is_bool($text)) {
            return $text;
        }

        $defaultCharset = 'UTF-8';

        if (is_string($double)) {
            $charset = $double;
            $double = true;
        }
        return htmlspecialchars($text, ENT_QUOTES, ($charset) ? $charset : $defaultCharset, $double);
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

function create_flash_message(string $message, string $type): void {
    $_SESSION['FLASH_MESSAGES'][] = ['message' => $message, 'type' => $type];
}

function format_flash_message(array $flash_message): string {
    return sprintf('<div class="alert alert-%s">%s</div>',
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

function checkPermission(int $userId, string $permission) {
    
}

function validatePermission(int $userId, string $permission) {
    
}
