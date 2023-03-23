<?php

$trs = '<tr>';
$clientes = $clientes ?? [];
foreach ($clientes as $cliente) {
    
    $dataCadastro = !empty($cliente->created_at) ? date('d/m/y H:i:s', strtotime($cliente->created_at)) : '-';
    
    $trs .= '<th scope="row">' . $cliente->id . '</th>';
    $trs .= '<td>' . $cliente->nome . '</td>';
    $trs .= '<td>' . $cliente->getTipoPessoaFullName() . '</td>';
    $trs .= '<td>' . $cliente->getPapelFullName() . '</td>';
    $trs .= '<td>' . $dataCadastro . '</td>';
    $trs .= '<td>' . implode(' ', $cliente->getActions($cliente)). '</td>';
    $trs .= '</tr>';
}

?>

<div class="col-lg-12" style="text-align: right;">
    <a href ="<?php echo base_url("/clientes/cadastrar"); ?>"  class="btn btn-sm btn-success text-decorator-none mb-2">                    
        <i class="bi bi-pencil-square"> Cadastrar</i> 
    </a>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Pessoa</th>
      <th scope="col">Tipo</th>
      <th scope="col">Cadastro</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $trs; ?>
  </tbody>
</table>

