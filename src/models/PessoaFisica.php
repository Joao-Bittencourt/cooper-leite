<?php

namespace CooperLeite\models;

use \core\Model;
use CooperLeite\models\Cliente;

class PessoaFisica extends Model {

    protected $table = 'pessoa_fisicas';
    protected $fillable = [
        'id',
        'cliente_id',
        'nome_civil',
        'dt_nascimento',
        'cpf',
        'rg',
        'created_at',
        'updated_at'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function processarSalvar($data = []) {

        // @ToDo: refatorar este formato está muito tosco
        $this->nome_civil = array_get($data, 'PessoaFisica-nome_civil');
        $this->dt_nascimento = array_get($data, 'PessoaFisica-dt_nascimento') ? date('Y-m-d h:i:s',
                        strtotime(
                                str_replace('/', '-', array_get($data, 'PessoaFisica-dt_nascimento'))
                        )
                ) : null;
        $this->cpf = array_get($data, 'PessoaFisica-cpf');
        $this->rg = array_get($data, 'PessoaFisica-rg');

        return $this->_save();
    }

}
