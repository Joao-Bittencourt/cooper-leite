<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\Cliente;

class ClientesController extends Controller {

    public function list() {
        $Cliente = new Cliente();
        $this->data['clientes'] = $Cliente::all();
    }

    public function cadastrar() {
        
    }

    public function store($args) {

        $Cliente = new Cliente();
        $Cliente->salvar(array_get($this->data, 'Request.data'));

        if (!empty($Cliente->erros)) {
            process_error_message($Cliente->erros);
            $this->redirect('/clientes/cadastrar');
        }
        create_flash_message('Cliente cadastrado com sucesso!', 'success');
        $this->redirect('/clientes');
    }

}
