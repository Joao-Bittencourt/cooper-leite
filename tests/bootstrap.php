<?php

namespace core {
    if (!function_exists('core\headers_sent')) {
        function headers_sent() {
            if (isset($GLOBALS['mock_headers_sent']) && $GLOBALS['mock_headers_sent'] === true) {
                return true;
            }
            return \headers_sent();
        }
    }
}

namespace {
    require_once __DIR__ . '/../vendor/autoload.php';
}
