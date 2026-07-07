<?php

namespace CooperLeite\models;

use core\Model;
use CooperLeite\models\User;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'status'
    ];

    public function group()
    {
        return $this->hasMany(User::class);
    }

    public function salvar($groupData = [])
    {
        if (empty($groupData)) {
            $this->erros[] = 'Dados inexistentes para salvar.';
            return false;
        }

        $this->name = array_get($groupData, 'name');
        $this->status = array_get($groupData, 'status', 1);

        return $this->save();
    }
}
