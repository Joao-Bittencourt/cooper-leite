<?php

$trs = '<tr>';
$users = $users ?? [];
foreach ($users as $user) {
    $dataCadastro = !empty($user->created_at) ? date('d/m/y H:i:s', strtotime($user->created_at)) : '-';

    $trs .= '<th scope="row">' . $user->id . '</th>';
    $trs .= '<td>' . $user->login . '</td>';
    $trs .= '<td>' . $user->email . '</td>';
    $trs .= '<td>' . $dataCadastro . '</td>';
    $trs .= '</tr>';
}

echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Login</th>
      <th scope="col">Email</th>
      <th scope="col">Cadastro</th>
    </tr>
  </thead>
  <tbody>
    ' . $trs . '
  </tbody>
</table>';
