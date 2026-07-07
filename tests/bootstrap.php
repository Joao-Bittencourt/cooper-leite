<?php

namespace core {
    if (!function_exists('core\headers_sent')) {
        function headers_sent() {
            if (isset($GLOBALS['mock_headers_sent'])) {
                return (bool) $GLOBALS['mock_headers_sent'];
            }
            return \headers_sent();
        }
    }
}

namespace {
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/core/basics.php';
}
