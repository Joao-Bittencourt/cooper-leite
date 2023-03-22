<?php

namespace CooperLeite\models;

use \core\Model;
use CooperLeite\models\User;
use CooperLeite\models\PessoaFisica;
use CooperLeite\models\PessoaJuridica;

class Cliente extends Model {

    protected $table = 'clientes';
    public $fillable = [
        'id',
        'nome',
        'tipo_pessoa',
        'papel',
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
        'tipo_pessoa' => [
            'notEmpty' => [
                'message' => 'Selecione o tipo de pessoa.'
            ],
            'custom' => [
                'args' => '/^(F|J)$/',
                'message' => 'Informe um tipo de pessoa valido.'
            ]
        ],
        'papel' => [
            'notEmpty' => [
                'message' => 'Selecione o tipo.'
            ],
            'custom' => [
                'args' => '/^(C|F|I)$/',
                'message' => 'Informe um tipo de pessoa valido.'
            ]
        ],
    ];
    public $clientePapel = [
        'C' => 'Cliente',
        'F' => 'Fornecedor',
        'I' => 'Funcionario'
    ];
    public $clienteTipoPessoa = [
        'F' => 'Fisica',
        'J' => 'Juridica'
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function pessoaFisica() {
        return $this->hasOne(PessoaFisica::class);
    }

    public function pessoaJuridica() {
        return $this->hasOne(PessoaJuridica::class);
    }

    public function salvar($data = []) {

        if (empty($data)) {
            $this->erros[] = 'Dados inexistentes para salvar.';
            return false;
        }

        $this->modelData = $data;
        $this->nome = array_get($data, 'nome');
        $this->tipo_pessoa = array_get($data, 'tipo_pessoa');
        $this->papel = array_get($data, 'papel');
        $this->status = array_get($data, 'status', 1);

        $this->_save();

        if ($this->id) {

            if ($this->tipo_pessoa == 'F') {
                $PessoaFisica = new PessoaFisica();
                $PessoaFisica->cliente_id = $this->id;
                $PessoaFisica->processarSalvar($data);
            }

            if ($this->tipo_pessoa == 'J') {
                $PessoaJuridica = new PessoaJuridica();
                $PessoaJuridica->cliente_id = $this->id;
                $PessoaJuridica->processarSalvar($data);
            }
        }

        return $this->id;
    }

    public function atualizar($data = []) {

        $this->modelData = array_get($data, 'Request.data');
        $this->_update();

        if ($this->tipo_pessoa == 'F') {
            $PessoaFisica = new PessoaFisica();
            $PessoaFisica->cliente_id = $this->id;
            $PessoaFisica->processarSalvar(array_get($data, 'Request.data'));
        }

        if ($this->tipo_pessoa == 'J') {
            $PessoaJuridica = new PessoaJuridica();
            $PessoaJuridica->cliente_id = $this->id;
            $PessoaJuridica->processarSalvar(array_get($data, 'Request.data'));
        }

        return $this->id;
    }

    public function getActions(Cliente $cliente): array {

        if (isset($cliente->id)) {

            return [
                '<a href ="' . base_url("/clientes/show/{$cliente->id}") . '" title="Detalhar" class="btn btn-sm btn-outline-info text-decorator-none">                    
                    <i class="bi bi-card-text"></i>
                </a>',
                '<a href ="' . base_url("/clientes/edit/{$cliente->id}") . '" title="Editar" class="btn btn-sm btn-outline-warning text-decorator-none">                    
                    <i class="bi bi-pencil-square"></i> 
                </a>',
            ];
        }

        return [];
    }

    public function getPapelFullName() {

        if (isset($this->papel)) {
            return isset($this->clientePapel[$this->papel]) ? $this->clientePapel[$this->papel] : '-';
        }

        return '-';
    }

    public function getTipoPessoaFullName() {

        if (isset($this->tipo_pessoa)) {
            return isset($this->clienteTipoPessoa[$this->tipo_pessoa]) ? $this->clienteTipoPessoa[$this->tipo_pessoa] : '-';
        }

        return '-';
    }

}
