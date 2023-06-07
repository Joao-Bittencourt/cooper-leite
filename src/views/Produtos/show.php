<?php

$produto = array_get((array)$this->data, 'produto');

if (!empty($produto)) {

    $id = $produto->id;
    $nome = $produto->nome;
    $descricao = $produto->descricao;
    $unidade = $produto->unidade;
    
   
    
    
  
?>    

<div class="col-lg-12" style="text-align: right;">
    <a href ="<?php echo base_url("/produtos/edit/{$produto->id}");?>"  class="btn btn-sm btn-warning text-decorator-none mb-2">                    
        <i class="bi bi-pencil-square"> Editar</i> 
    </a>
</div>
<div class="card">
    <div class="card-header">Produto #<?php echo $id; ?></div>
    <div class="car-body">
        <div class="col-sm-12 m-3">

            <div class="row mb-5 border-bottom">
                <div class="col-sm-6">
                    <label>Nome</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $nome; ?>">
                </div>
                <div class="col-sm-6">
                    <label>Descricao</label>
                    <input type="text" class="form-control-plaintext" readonly  value="<?php echo $descricao; ?>">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Unidade</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo $unidade; ?>">
                </div>
               

            </div>

        </div>
    </div>
</div>

<?php
} else {
    echo '
        <div class="alert alert-primary" role="alert">
            Produto não encontrado!.
        </div>
    ';
}