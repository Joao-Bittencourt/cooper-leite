<?php

namespace CooperLeite\models;

use core\Model;
use CooperLeite\models\Cliente;

class PessoaFisica extends Model
{
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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // @ToDo: refatorar este formato está muito tosco
    public function processarSalvar($data = [])
    {
        if (is_numeric(array_get($data, 'PessoaFisica-id'))) {
            $this->id = array_get($data, 'PessoaFisica-id');
        }

        $this->nome_civil = array_get($data, 'PessoaFisica-nome_civil');
        $this->dt_nascimento = array_get($data, 'PessoaFisica-dt_nascimento') ? date(
            'Y-m-d h:i:s',
            strtotime(
                str_replace('/', '-', array_get($data, 'PessoaFisica-dt_nascimento'))
            )
        ) : null;
        $this->cpf = array_get($data, 'PessoaFisica-cpf');
        $this->rg = array_get($data, 'PessoaFisica-rg');
        $this->status = array_get($data, 'PessoaFisica-status', 1);

        return $this->id ? $this->_save(1) : $this->_save();
    }
}
