<?php

namespace CooperLeite\models;

use core\Model;

class Produto extends Model
{
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

    public function salvar($produtoData = [])
    {
        $this->modelData = $produtoData;
        $this->nome = array_get($produtoData, 'nome');
        $this->descricao = array_get($produtoData, 'descricao');
        $this->unidade = array_get($produtoData, 'unidade');
        $this->status = array_get($produtoData, 'status', 1);
        return $this->_save();
    }

    public function atualizar($produtoData = [])
    {
        $this->modelData = $produtoData;
        $this->nome = array_get($produtoData, 'nome', $this->nome);
        $this->descricao = array_get($produtoData, 'descricao', $this->descricao);
        $this->unidade = array_get($produtoData, 'unidade', $this->unidade);
        $this->status = array_get($produtoData, 'status', 1);

        return $this->_update();
    }

    public function getActions(Produto $produto): array
    {
        if (isset($produto->id)) {
            return [
                '<a href ="' . base_url("/produtos/show/{$produto->id}") . '" title="Detalhar" class="btn btn-sm btn-outline-info text-decorator-none">                    
                    <i class="bi bi-card-text"></i>
                </a>',
                '<a href ="' . base_url("/produtos/edit/{$produto->id}") . '" title="Editar" class="btn btn-sm btn-outline-warning text-decorator-none">                    
                    <i class="bi bi-pencil-square"></i> 
                </a>',
            ];
        }

        return [];
    }
}
