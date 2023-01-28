<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\User;

class UsersController extends Controller {

    public function list() {
        $User = new User();
        $this->data['users'] = $User::all();
    }

    public function cadastrar() {
        
    }

    public function store($args = []) {

        $User = new User();
        $User->salvar(array_get($this->data, 'Request.data'));

        if (!empty($User->erros)) {
            process_error_message($User->erros);
            $this->redirect('/users/cadastrar');
        }

        create_flash_message('Usuario cadastrado com sucesso!', 'success');
        $this->redirect('/users');
    }

}