<?php

$trs = '<tr>';
$produtos = $produtos ?? [];
foreach ($produtos as $produto) {

    $dataCadastro = !empty($produto->created_at) ? date('d/m/y H:i:s', strtotime($produto->created_at)) : '-';
    
    $trs .= '<th scope="row">' . $produto->id . '</th>';
    $trs .= '<td>' . $produto->nome . '</td>';
    $trs .= '<td>' . $dataCadastro . '</td>';
    $trs .= '<td>' . implode(' ', $produto->getActions($produto)) . '</td>';
    $trs .= '</tr>';
}

echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Cadastro</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    ' . $trs . '
  </tbody>
</table>';

