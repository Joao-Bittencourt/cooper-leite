<?php

namespace core;

use CooperLeite\Config;

class CoreException extends \Exception
{
    public function __construct($message, $code = 500)
    {
        http_response_code($code);
        $controllerErrorName = Config::ERROR_CONTROLLER;
        $controllerError = "\CooperLeite\controllers\\$controllerErrorName";
        $controller = new $controllerError();
        $controller->layout = 'exception';
        $controller->layout('exception', [
            'message' => $message,
            'code' => $code
        ]);

        write_log(
            "{$message} code: {$code} url:" . Request::getUrl()
        );
    }
}
