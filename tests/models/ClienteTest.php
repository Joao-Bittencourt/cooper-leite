<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\Cliente;
use CooperLeite\models\PessoaFisica;
use CooperLeite\models\PessoaJuridica;

class ClienteTest extends ModelTestCase
{
    public function test_salvar_empty_data()
    {
        $cliente = new Cliente();
        $result = $cliente->salvar([]);
        
        $this->assertFalse($result);
        $this->assertContains('Dados inexistentes para salvar.', $cliente->erros);
    }

    public function test_salvar_fails_validation()
    {
        $cliente = new Cliente();
        $result = $cliente->salvar([
            'nome' => '',
            'tipo_pessoa' => 'X',
            'papel' => 'Y'
        ]);
        
        $this->assertNull($result);
        $this->assertNotEmpty($cliente->erros);
    }

    public function test_salvar_pessoa_fisica_success()
    {
        $cliente = new Cliente();
        $data = [
            'nome' => 'Joao Silva',
            'tipo_pessoa' => 'F',
            'papel' => 'C',
            'PessoaFisica-nome_civil' => 'Joao Social',
            'PessoaFisica-dt_nascimento' => '12/10/1990',
            'PessoaFisica-cpf' => '12345678909',
            'PessoaFisica-rg' => 'MG123456',
            'status' => 1
        ];

        $clientId = $cliente->salvar($data);
        
        $this->assertNotEmpty($clientId);
        
        $dbCliente = Cliente::find($clientId);
        $this->assertEquals('Joao Silva', $dbCliente->nome);
        $this->assertEquals('F', $dbCliente->tipo_pessoa);

        $dbPessoaFisica = PessoaFisica::where('cliente_id', $clientId)->first();
        $this->assertNotEmpty($dbPessoaFisica);
        $this->assertEquals('Joao Social', $dbPessoaFisica->nome_civil);
        $this->assertEquals('1990-10-12 12:00:00', $dbPessoaFisica->dt_nascimento);
    }

    public function test_salvar_pessoa_juridica_success()
    {
        $cliente = new Cliente();
        $data = [
            'nome' => 'Empresa Exemplo',
            'tipo_pessoa' => 'J',
            'papel' => 'F',
            'PessoaJuridica-cnpj' => '12345678000199',
            'PessoaJuridica-razao_social' => 'Exemplo Ltda',
            'status' => 1
        ];

        $clientId = $cliente->salvar($data);
        
        $this->assertNotEmpty($clientId);
        
        $dbCliente = Cliente::find($clientId);
        $this->assertEquals('Empresa Exemplo', $dbCliente->nome);
        $this->assertEquals('J', $dbCliente->tipo_pessoa);

        $dbPessoaJuridica = PessoaJuridica::where('cliente_id', $clientId)->first();
        $this->assertNotEmpty($dbPessoaJuridica);
        $this->assertEquals('Exemplo Ltda', $dbPessoaJuridica->razao_social);
    }

    public function test_atualizar_pessoa_fisica()
    {
        $cliente = new Cliente();
        $data = [
            'nome' => 'Joao Silva',
            'tipo_pessoa' => 'F',
            'papel' => 'C',
            'PessoaFisica-nome_civil' => 'Joao Social',
            'PessoaFisica-dt_nascimento' => '12/10/1990',
            'PessoaFisica-cpf' => '12345678909',
            'PessoaFisica-rg' => 'MG123456',
            'status' => 1
        ];
        $clientId = $cliente->salvar($data);

        $clienteToUpdate = Cliente::find($clientId);
        $updateData = [
            'Request' => [
                'data' => [
                    'PessoaFisica-id' => $clienteToUpdate->pessoaFisica->id,
                    'PessoaFisica-nome_civil' => 'Joao Social Updated',
                    'PessoaFisica-dt_nascimento' => '15/10/1990'
                ]
            ]
        ];

        $result = $clienteToUpdate->atualizar($updateData);
        $this->assertEquals($clientId, $result);

        $dbPessoaFisica = PessoaFisica::where('cliente_id', $clientId)->first();
        $this->assertEquals('Joao Social Updated', $dbPessoaFisica->nome_civil);
    }

    public function test_atualizar_pessoa_juridica()
    {
        $cliente = new Cliente();
        $data = [
            'nome' => 'Empresa Exemplo',
            'tipo_pessoa' => 'J',
            'papel' => 'F',
            'PessoaJuridica-cnpj' => '12345678000199',
            'PessoaJuridica-razao_social' => 'Exemplo Ltda',
            'status' => 1
        ];
        $clientId = $cliente->salvar($data);

        $clienteToUpdate = Cliente::find($clientId);
        $updateData = [
            'Request' => [
                'data' => [
                    'PessoaJuridica-id' => $clienteToUpdate->pessoaJuridica->id,
                    'PessoaJuridica-razao_social' => 'Exemplo Ltda Updated'
                ]
            ]
        ];

        $result = $clienteToUpdate->atualizar($updateData);
        $this->assertEquals($clientId, $result);

        $dbPessoaJuridica = PessoaJuridica::where('cliente_id', $clientId)->first();
        $this->assertEquals('Exemplo Ltda Updated', $dbPessoaJuridica->razao_social);
    }

    public function test_get_actions()
    {
        $cliente = new Cliente();
        $this->assertEmpty($cliente->getActions($cliente));

        $cliente->salvar([
            'nome' => 'Joao Silva',
            'tipo_pessoa' => 'F',
            'papel' => 'C'
        ]);

        $actions = $cliente->getActions($cliente);
        $this->assertCount(2, $actions);
    }

    public function test_get_papel_full_name()
    {
        $cliente = new Cliente();
        $this->assertEquals('-', $cliente->getPapelFullName());

        $cliente->papel = 'C';
        $this->assertEquals('Cliente', $cliente->getPapelFullName());

        $cliente->papel = 'X';
        $this->assertEquals('-', $cliente->getPapelFullName());
    }

    public function test_get_tipo_pessoa_full_name()
    {
        $cliente = new Cliente();
        $this->assertEquals('-', $cliente->getTipoPessoaFullName());

        $cliente->tipo_pessoa = 'F';
        $this->assertEquals('Fisica', $cliente->getTipoPessoaFullName());

        $cliente->tipo_pessoa = 'X';
        $this->assertEquals('-', $cliente->getTipoPessoaFullName());
    }

    public function test_relationships()
    {
        $cliente = new Cliente();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $cliente->user());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $cliente->pessoaFisica());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $cliente->pessoaJuridica());
    }
}
