<?php

if (!function_exists('base_url')) {

    function base_url($url) {
        return dirname($_SERVER['SCRIPT_NAME']) . $url;
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

