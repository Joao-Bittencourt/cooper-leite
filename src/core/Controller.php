<?php

namespace core;

use \CooperLeite\Config;

class Controller {

    public $data = [];
    public $layout = 'default';
    public $action;

    public function _checkAuth() {

        $isAuth = \core\Auth::checkAuth();
        $isAuthorized = \core\Auth::checkAuthorization($this->controller, $this->action, $isAuth);

        if (!$isAuth && !$isAuthorized) {
            create_flash_message('Usuario não autenticado!', 'danger');
            $this->redirect('/auth/user');
        }

        if ($isAuth && !$isAuthorized) {
            create_flash_message('Usuario sem permissao!', 'danger');
            $this->redirect('/dashboard');
        }
        
        return $isAuth;
    }

    public function render($viewName, $viewData = []) {

        $folderName = $this->folderName();
        return $this->_render($folderName . '/' . $viewName, $viewData);
    }

    public function renderLayout($viewName, $viewData = []) {

//        $content = '';
//        ob_start();
//
//        $this->render($viewName, $viewData);
//
////        $content = ob_get_clean();
//        $content = ob_get_flush();

        return $this->_render('layout/' . $this->layout,
                ['content' => $this->render($viewName, $viewData)]
        );
    }

    public function layout($content, $data = []) {

        $data = array_merge($data, $this->data);

        return $this->renderLayout($content, $data);
    }

    protected function redirect($url) {
        header("Location: " . base_url($url), true, 302);
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
        
        ob_start();
            extract($viewData);
            $render = fn($vN, $vD = []) => $this->renderPartial($vN, $vD);
            $base = $this->getBaseUrl();
            @require './src/views/' . $page . '.php';

        return ob_get_clean();
    }

    private function folderName($folder = ''): string {

        if (!empty($folder)) {
            return $folder;
        }

        $controllerName = str_replace('Controller', '', (new \ReflectionClass($this))->getShortName());
        if (!empty($controllerName) && is_dir('./src/views/' . $controllerName)) {
            return $controllerName;
        }

        return 'pages';
    }

    private function renderPartial($viewName, $viewData = []) {
        return $this->_render('partials', $viewName, $viewData);
    }

}
