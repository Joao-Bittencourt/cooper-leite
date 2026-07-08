<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\Produto;

class ProdutoTest extends ModelTestCase
{
    public function test_salvar_fails_validation()
    {
        $produto = new Produto();
        $result = $produto->salvar([
            'nome' => '',
            'unidade' => ''
        ]);
        
        $this->assertFalse($result);
        $this->assertNotEmpty($produto->erros);
        $this->assertEquals('Nome deve ser preenchido.', $produto->erros['nome'][0]);
        $this->assertEquals('Unidade deve ser preenchido.', $produto->erros['unidade'][0]);
    }

    public function test_salvar_success()
    {
        $produto = new Produto();
        $result = $produto->salvar([
            'nome' => 'Leite Integrador',
            'descricao' => 'Leite integral tipo A',
            'unidade' => 'LITROS'
        ]);
        
        $this->assertTrue($result);
        $this->assertEquals('Leite Integrador', $produto->nome);
        $this->assertEquals('LITROS', $produto->unidade);
        $this->assertEquals(1, $produto->status);
        
        $dbRecord = Produto::first();
        $this->assertEquals('Leite Integrador', $dbRecord->nome);
    }

    public function test_atualizar_fails_validation()
    {
        $produto = new Produto();
        $produto->salvar([
            'nome' => 'Leite Integrador',
            'descricao' => 'Leite integral tipo A',
            'unidade' => 'LITROS'
        ]);

        $produto->nome = '';
        $result = $produto->atualizar([
            'nome' => '',
            'unidade' => 'LITROS'
        ]);

        $this->assertFalse($result);
    }

    public function test_atualizar_success()
    {
        $produto = new Produto();
        $produto->salvar([
            'nome' => 'Leite Integrador',
            'descricao' => 'Leite integral tipo A',
            'unidade' => 'LITROS'
        ]);

        $result = $produto->atualizar([
            'nome' => 'Leite Desnatado',
            'descricao' => 'Leite desnatado UHT',
            'unidade' => 'UN'
        ]);

        $this->assertTrue($result);
        $this->assertEquals('Leite Desnatado', $produto->nome);
        $this->assertEquals('UN', $produto->unidade);
    }

    public function test_get_actions()
    {
        $produto = new Produto();
        
        $actionsEmpty = $produto->getActions($produto);
        $this->assertEmpty($actionsEmpty);

        $produto->salvar([
            'nome' => 'Leite Integrador',
            'unidade' => 'LITROS'
        ]);

        $actions = $produto->getActions($produto);
        $this->assertCount(2, $actions);
        $this->assertStringStartsWith('<a href ="', $actions[0]);
        $this->assertStringStartsWith('<a href ="', $actions[1]);
        $this->assertStringContainsString('href ="' . base_url("/produtos/show/{$produto->id}") . '"', $actions[0]);
        $this->assertStringContainsString('href ="' . base_url("/produtos/edit/{$produto->id}") . '"', $actions[1]);
        $this->assertStringContainsString('class="btn btn-sm btn-outline-info text-decorator-none"', $actions[0]);
        $this->assertStringContainsString('class="btn btn-sm btn-outline-warning text-decorator-none"', $actions[1]);
    }
}
