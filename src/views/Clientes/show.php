<?php

$cliente = array_get((array)$this->data, 'Cliente');

if (!empty($cliente)) {

    $nome = $cliente->nome;
    $id = $cliente->id;
    $papel = $cliente->getPapelFullName();
    $nomeRazaoSocial = '-';
    $cpfCnpj = '-';
    
    if ($cliente->pessoa == 'F' && isset($cliente->pessoaFisica)) {
        $nomeRazaoSocial = $cliente->pessoaFisica->nome_civil;
        $cpfCnpj = $cliente->pessoaFisica->cpf;
    }
  
    if ($cliente->pessoa == 'J'&& isset($cliente->pessoaJuridica) ) {
        $nomeRazaoSocial = $cliente->pessoaJuridica->razao_social;
        $cpfCnpj = $cliente->pessoaJuridica->cnpj;
    }
    
?>    

<div class="col-lg-12" style="text-align: right;">
    <a href ="<?php echo base_url("/clientes/edit/{$cliente->id}");?>"  class="btn btn-sm btn-warning text-decorator-none mb-2">                    
        <i class="bi bi-pencil-square"> Editar</i> 
    </a>
</div>
<div class="card">
    <div class="card-header">Cliente #<?php echo $id; ?></div>
    <div class="car-body">
        <div class="col-sm-12 m-3">

            <div class="row mb-5 border-bottom">
                <div class="col-sm-6">
                    <label>Nome</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $nome; ?>">
                </div>
                <div class="col-sm-6">
                    <label>Tipo</label>
                    <input type="text" class="form-control-plaintext" readonly  value="<?php echo $papel; ?>">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Nome civil / Razão social</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $nomeRazaoSocial; ?>">
                </div>
                <div class="col-sm-6">
                    <label>CPF / CNPJ</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $cpfCnpj; ?>">
                </div>

            </div>

        </div>
    </div>
</div>

<?php
} else {
    echo '
        <div class="alert alert-primary" role="alert">
            Cliente não encontrado!.
        </div>
    ';
}