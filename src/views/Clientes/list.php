<?php


$trs = '<tr>';
foreach ($clientes as $cliente) {

    $dataCadastro = !empty($cliente->created_at) ? date('d/m/y H:i:s', strtotime($cliente->created_at)) : '-';
    
    $trs .= '<th scope="row">' . $cliente->id . '</th>';
    $trs .= '<td>' . $cliente->nome . '</td>';
    $trs .= '<td>' . $cliente->tipo_pessoa . '</td>';
    $trs .= '<td>' . $cliente->papel . '</td>';
    $trs .= '<td>' . $dataCadastro . '</td>';
    $trs .= '</tr>';
}

echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Pessoa</th>
      <th scope="col">Tipo</th>
      <th scope="col">Cadastro</th>
    </tr>
  </thead>
  <tbody>
    ' . $trs . '
  </tbody>
</table>';

