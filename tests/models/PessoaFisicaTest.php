<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\PessoaFisica;

class PessoaFisicaTest extends ModelTestCase
{
    public function test_relationship()
    {
        $pf = new PessoaFisica();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $pf->cliente());
    }

    public function test_processar_salvar()
    {
        $pf = new PessoaFisica();

        $data = [
            'PessoaFisica-id' => 'abc',
            'PessoaFisica-nome_civil' => 'Nome Social',
            'PessoaFisica-dt_nascimento' => '25/12/1995',
            'PessoaFisica-cpf' => '00000000000',
            'PessoaFisica-rg' => 'RG123',
            'PessoaFisica-status' => 1
        ];

        $result = $pf->processarSalvar($data);
        $this->assertTrue($result);

        $this->assertEquals('Nome Social', $pf->nome_civil);
        $this->assertEquals('1995-12-25 12:00:00', $pf->dt_nascimento);
    }
}
