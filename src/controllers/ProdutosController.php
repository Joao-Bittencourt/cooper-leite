<?php

namespace CooperLeite\controllers;

use CooperLeite\models\Produto;

class ProdutosController extends AppController {
    
    public function list() {
        $Produto = new Produto();
        $this->data['produtos'] = $Produto::all();
    }

    public function cadastrar() {}
        
    public function store($args = []) {

        $Produto = new Produto();
        $Produto->salvar(array_get($this->data, 'Request.data'));

        if (!empty($Produto->erros)) {
            process_error_message($Produto->erros);
            $this->redirect('/produtos/cadastrar');
        }

        create_flash_message('Produto cadastrado com sucesso!', 'success');
        $this->redirect('/produtos');
    }
}

