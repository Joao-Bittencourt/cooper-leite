<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\PessoaJuridica;

class PessoaJuridicaTest extends ModelTestCase
{
    public function test_relationship()
    {
        $pj = new PessoaJuridica();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $pj->cliente());
    }

    public function test_processar_salvar()
    {
        $pj = new PessoaJuridica();
        
        $data = [
            'PessoaJuridica-id' => 'abc',
            'PessoaJuridica-cnpj' => '12345678000100',
            'PessoaJuridica-razao_social' => 'Empresa Social'
        ];

        $result = $pj->processarSalvar($data);
        $this->assertTrue($result);
        
        $this->assertEquals('Empresa Social', $pj->razao_social);
        $this->assertEquals('12345678000100', $pj->cnpj);
    }
}
