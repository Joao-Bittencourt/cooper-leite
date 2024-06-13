<?php

namespace core;

use CooperLeite\Config;
use core\CoreException;

class RouterBase
{
    public function run($routes)
    {
        $method = Request::getMethod();
        $url = Request::getUrl();

        // Define os itens padrão
        $resourceNotFound = true;
        $controllerName = null;
        $action = Config::DEFAULT_ACTION;
        $args = [];

        if (isset($routes[$method])) {
            foreach ($routes[$method] as $route => $callback) {
                // Identifica os argumentos e substitui por regex
                $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $route);

                // Faz o match da URL
                if (preg_match('#^(' . $pattern . ')*$#i', $url, $matches) === 1) {
                    array_shift($matches);
                    array_shift($matches);

                    // Pega todos os argumentos para associar
                    $itens = array();
                    if (preg_match_all('(\{[a-z0-9]{1,}\})', $route, $m)) {
                        $itens = preg_replace('(\{|\})', '', $m[0]);
                    }

                    // Faz a associação
                    $args = array();
                    foreach ($matches as $key => $match) {
                        $args[$itens[$key]] = $match;
                    }

                    // Seta o controller/action
                    $callbackSplit = explode('@', $callback);
                    $controllerName = $callbackSplit[0];
                    if (isset($callbackSplit[1])) {
                        $action = $callbackSplit[1];
                    }

                    $this->execute($controllerName, $action, $args);
                    $resourceNotFound = false;
                    break;
                }
            }
        }

        if ($resourceNotFound) {
            throw new CoreException("{$url} not found.", 404);
        }
    }

    public function execute($controllerName, $action, $args)
    {
        if (empty($controllerName)) {
            throw new CoreException("Controller not exists.");
        }

        if (!class_exists("\CooperLeite\controllers\\$controllerName")) {
            throw new CoreException("{$controllerName} not exists.");
        }

        $controller = "\CooperLeite\controllers\\$controllerName";
        $definedController = new $controller();

        if (!method_exists($definedController, $action)) {
            throw new CoreException("{$action} not exists in {$controllerName}");
        }

        //@ToDo: separar a view para classe expecifica
        // criar estrutura de helpers para view

        $definedController->data['Request']['args'] = $args;
        $definedController->data['Request']['data'] = Request::getRequestData();
        $definedController->controller = str_replace('Controller', '', $controllerName) ;
        $definedController->action = $action;

        $definedController->_checkAuth();

        $definedController->$action($args);
        echo $definedController->layout($action, $args);
    }
}
