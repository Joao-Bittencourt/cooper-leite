<?php

$trs = '<tr>';
$groups = $groups ?? [];
foreach ($groups as $group) {

    $dataCadastro = !empty($group->created_at) ? date('d/m/y H:i:s', strtotime($group->created_at)) : '-';
    
    $trs .= '<th scope="row">' . $group->id . '</th>';
    $trs .= '<td>' . $group->name . '</td>';
    $trs .= '<td>' . $dataCadastro . '</td>';
    $trs .= '</tr>';
}

echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Cadastro</th>
    </tr>
  </thead>
  <tbody>
    ' . $trs . '
  </tbody>
</table>';

