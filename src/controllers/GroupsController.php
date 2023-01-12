<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\Group;

class GroupsController extends Controller {

    public function list() {
        $Group = new Group();
        $this->data['groups'] = $Group::all();
    }

    public function cadastrar() {
        
    }

    public function store($args) {

        $Group = new Group();
        $Group->salvar(array_get($this->data, 'Request.data'));

        if (!empty($Group->erros)) {
            debug($Group->erros);
            die();
        }
        create_flash_message('Grupo cadastrado com sucesso!', 'success');
        $this->redirect('/groups');
    }

}
