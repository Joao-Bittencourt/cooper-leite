<?php

namespace core;

use \CooperLeite\Config;

class Controller {

    public $data = [];
    
    protected function redirect($url) {
        header("Location: " . base_url($url));
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

    private function _render($page, $viewData = []) {

        if (!file_exists('./src/views/' . $page . '.php')) {
            throw new \Exception("Page {$page} not found.");
        }

        extract($viewData);
        $render = fn($vN, $vD = []) => $this->renderPartial($vN, $vD);
        $base = $this->getBaseUrl();
        require './src/views/' . $page . '.php';
    }

    private function folderName($folder = ''): string {

        if (!empty($folder)) {
            return $folder;
        }
        
        $controllerName = str_replace('Controller', '', (new \ReflectionClass($this))->getShortName());
        if (is_dir('./src/views/' . $controllerName)) {
            return $controllerName;
        }

        return 'pages';
        
    }

    private function renderPartial($viewName, $viewData = []) {
        $this->_render('partials', $viewName, $viewData);
    }

    public function render($viewName, $viewData = []) {

        $folderName = $this->folderName();
        $this->_render($folderName . '/' . $viewName, $viewData);
    }

    public function layout($content, $data = []) {
        
        $data = array_merge($data, $this->data);
        
        $this->_render('layout/header');
        $this->render($content, $data);
        $this->_render('layout/footer');
    }

}
