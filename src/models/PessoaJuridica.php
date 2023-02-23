<?php

namespace CooperLeite\models;

use \core\Model;
use CooperLeite\models\Cliente;

class PessoaJuridica extends Model {

    protected $table = 'pessoa_juridicas';
    protected $fillable = [
        'id',
        'cliente_id',
        'cnpj',
        'razao_social',
        'created_at',
        'updated_at'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    // @ToDo: refatorar este formato está muito tosco
    public function processarSalvar($data = []) {

        if (is_numeric(array_get($data, 'PessoaJuridica-id'))) {
            $this->id = array_get($data, 'PessoaJuridica-id');
        }
        
        $this->cnpj = array_get($data, 'PessoaJuridica-cnpj');
        $this->razao_social = array_get($data, 'PessoaJuridica-razao_social');

        return $this->id ? $this->_save(1) : $this->_save();
    }

}
