<?php

namespace CooperLeite\controllers;

use CooperLeite\models\Produto;

class ProdutosController extends AppController {

    public function list() {
        $Produto = new Produto();
        $this->data['produtos'] = $Produto::all();
    }

    public function add() {
        // method only to autoRender view
    }

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

    public function show($params) {

        $id = array_get($params, 'id', 0);
        $produtoId = !empty($id) && is_numeric($id) ? $id : 0;
        $produto = Produto::where('id', $produtoId)->first();

        if (empty($produto)) {
            create_flash_message("Produto #{$produtoId} não encontrado!", 'info');
            $this->redirect('/produtos');
        }

        $this->data['produto'] = $produto;
    }

    public function edit($params) {

        $id = array_get($params, 'id', 0);
        $produtoId = !empty($id) && is_numeric($id) ? $id : 0;
        $produto = Produto::where('id', $produtoId)->first();

        if (empty($produto)) {
            create_flash_message("Produto #{$produtoId} não encontrado!", 'info');
            $this->redirect('/produtos');
        }

        $this->data['produto'] = $produto;
    }

    public function update($params) {

        $id = array_get($params, 'id', 0);
        $produtoId = !empty($id) && is_numeric($id) ? $id : 0;
        $produto = Produto::where('id', $produtoId)->first();

        if (empty($produto)) {
            create_flash_message("Produto #{$produtoId} não encontrado!", 'info');
            $this->redirect('/produtos');
        }

        $produto->atualizar($this->data);

        if (!empty($produto->erros)) {
            process_error_message($produto->erros);
            $this->redirect('/produtos/edit/' . $produtoId);
        }

        create_flash_message('Produto editado com sucesso!', 'success');
        $this->redirect('/produtos');
    }
}
