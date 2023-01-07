<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\User;

class UsersController extends Controller {

    public function index() {
        $User = new User();

        $this->data['users'] = $User->select()
                ->join('groups', 'users.group_id', '=', 'groups.id')
                ->get();
    }

    public function cadastrar() {
        
    }

    public function store($args) {

        $User = new User();
        $User->salvar(array_get($this->data, 'Request.data'));

        if (!empty($User->erros)) {
            debug($User->erros);
            die();
        }
        
        $this->redirect('/users');
    }

}
