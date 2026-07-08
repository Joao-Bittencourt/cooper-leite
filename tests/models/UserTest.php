<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\User;

class UserTest extends ModelTestCase
{
    public function test_salvar_fails_validation()
    {
        $user = new User();
        $result = $user->salvar([
            'email' => '',
            'login' => '',
            'password' => ''
        ]);
        
        $this->assertFalse($result);
        $this->assertNotEmpty($user->erros);
        $this->assertEquals('Login deve ser preenchido.', $user->erros['login'][0]);
        $this->assertEquals('Email deve ser preenchido.', $user->erros['email'][0]);
        $this->assertEquals('Senha deve ser preenchida.', $user->erros['password'][0]);
    }

    public function test_salvar_success()
    {
        $user = new User();
        $result = $user->salvar([
            'email' => 'joao@example.com',
            'login' => 'joao',
            'password' => 'secret'
        ]);
        
        $this->assertTrue($result);
        $this->assertEquals('joao@example.com', $user->email);
        $this->assertEquals('joao', $user->login);
        $this->assertEquals(0, $user->group_id);
        $this->assertEquals(0, $user->cliente_id);
        $this->assertEquals(1, $user->status);
        
        $dbRecord = User::first();
        $this->assertEquals('joao@example.com', $dbRecord->email);
    }

    public function test_user_belongs_to_group()
    {
        $user = new User();
        $relation = $user->group();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }
}
