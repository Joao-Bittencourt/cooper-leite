<?php

namespace CooperLeite\models;

use \core\Model;

class User extends Model {

    protected $table = 'users';
    protected $fillable = [
        'id', 
        'email',
        'login',
        'group_id',
        'created_at',
        'updated_at'
    ];

    public function group() {
        return $this->belongsTo('Group');
    }

    public function salvar($userData = []) {

        if (empty($userData)) {
            $this->erros[] = 'Dados inexistentes para salvar.';
            return false;
        }

        $this->email = array_get($userData, 'email');
        $this->login = array_get($userData, 'login');
        $this->password = array_get($userData, 'password');
        $this->group_id = array_get($userData, 'group_id', 0);
        $this->cliente_id = array_get($userData, 'cliente_id', 0);
        $this->status = array_get($userData, 'status', 1);
        return $this->save();
    }
}
