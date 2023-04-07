<?php

namespace CooperLeite\models;

use \core\Model;

class Produto extends Model {

    protected $table = 'produtos';
    protected $fillable = [
        'id', 
        'nome',
        'descricao',
        'unidade',
        'created_at',
        'updated_at',
        'status'
    ];
    
    public $validate = [
        'nome' => [
            'notEmpty' => [
                'message' => 'Nome deve ser preenchido.'
            ],            
        ],
        'unidade' => [
            'notEmpty' => [
                'message' => 'Unidade deve ser preenchido.'
            ],            
        ]
    ];
    
    public function salvar($produtoData = []) {

        $this->modelData = $produtoData;
        $this->nome = array_get($produtoData, 'nome');
        $this->descricao = array_get($produtoData, 'descricao');
        $this->unidade = array_get($produtoData, 'unidade');
        $this->status = array_get($produtoData, 'status', 1);
        return $this->_save();
    }
}