<?php

namespace CooperLeite\models;

use \core\Model;

class Cliente extends Model {

    protected $table = 'clientes';
    protected $fillable = [
        'id', 
        'nome',
        'tipo_pessoa',
        'papel',
        'created_at',
        'updated_at',
        'status'
    ];
    
//    public function group() {
//        return $this->hasMany('User');
//    }

    public function salvar($data = []) {

        if (empty($data)) {
            $this->erros[] = 'Dados inexistentes para salvar.';
            return false;
        }

        $this->nome = array_get($data, 'nome');
        $this->tipo_pessoa = array_get($data, 'tipo_pessoa');
        $this->papel = array_get($data, 'papel');
        $this->status = array_get($data, 'status', 1);
  
        return $this->save();
    }
    
    public function getActions(Cliente $cliente): array {
          
        if (isset($cliente->id)) {
           return [];
        }
    }
}
