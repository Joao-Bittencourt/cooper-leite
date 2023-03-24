<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\User;

class UsersController extends AppController {

    public function list() {
        $User = new User();
        $this->data['users'] = $User::all();
    }

    public function cadastrar() {}
        
    public function store($args = []) {

        $User = new User();
        $User->salvar(array_get($this->data, 'Request.data'));

        if (!empty($User->erros)) {
            process_error_message($User->erros);
            $this->redirect('/usuarios/cadastrar');
        }

        create_flash_message('Usuario cadastrado com sucesso!', 'success');
        $this->redirect('/usuarios');
    }

    public function login() {
        $this->layout = 'login';
    }

    public function logout() {
        \core\Auth::logout();
        $this->redirect('/auth/user');
    }

    public function auth() {

        try {
            $jwt = \core\Auth::login($this->data['Request']['data']);
            
            if (!empty($jwt)) {
                $_SESSION['Auth']['jwt'] = $jwt;
                $this->redirect('/dashboard');
            }
            
        } catch (\Exception $ex) {
            process_error_message([[$ex->getMessage()]]);
            $this->redirect('/auth/user');
        }
    }

}
