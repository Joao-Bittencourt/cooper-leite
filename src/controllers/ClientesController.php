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

    public function show($params) {

        $id = array_get($params, 'id', 0);
        $clienteId = !empty($id) && is_numeric($id) ? $id : 0;
        $cliente = Cliente::where('id', $clienteId)->first();

        if (empty($cliente)) {
            create_flash_message("Cliente #{$clienteId} não encontrado!", 'info');
            $this->redirect('/clientes');
        }

        $this->data['Cliente'] = $cliente;
    }

    public function edit($params) {
        $id = array_get($params, 'id', 0);
        $clienteId = !empty($id) && is_numeric($id) ? $id : 0;
        $cliente = Cliente::where('id', $clienteId)->first();

        if (empty($cliente)) {
            create_flash_message("Cliente #{$clienteId} não encontrado!", 'info');
            $this->redirect('/clientes');
        }

        $this->data['Cliente'] = $cliente;
    }

}
