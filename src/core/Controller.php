<?php

namespace core;

use \CooperLeite\Config;

class Controller {

    protected function redirect($url) {
        header("Location: " . $this->getBaseUrl() . $url);
        exit;
    }

    private function getBaseUrl() {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        $base .= Config::BASE_DIR;

        return $base;
    }

    private function _render($folder, $viewName, $viewData = []) {

        if (!file_exists('./src/views/' . $folder . '/' . $viewName . '.php')) {
            throw new \Exception("{$viewName} not found in {$folder}");
        }

        extract($viewData);
        $render = fn($vN, $vD = []) => $this->renderPartial($vN, $vD);
        $base = $this->getBaseUrl();
        require './src/views/' . $folder . '/' . $viewName . '.php';
    }

    private function folderName($folder = 'pages'): string {
        
        $controllerName = str_replace('Controller', '', (new \ReflectionClass($this))->getShortName());
        if (is_dir('./src/views/' . $controllerName)) {
            return $controllerName;
        }
        
         return $folder;
    }
    private function renderPartial($viewName, $viewData = []) {
        $this->_render('partials', $viewName, $viewData);
    }

    public function render($viewName, $viewData = []) {
        
        $folderName = $this->folderName();
        $this->_render($folderName, $viewName, $viewData);
    }

}
