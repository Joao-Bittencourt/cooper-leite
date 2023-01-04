<?php

$trs = '<tr>';
foreach ($users as $user) {    
      $trs .= '<th scope="row">'. array_get($user, 'id'). '</th>';
      $trs .= '<td>'. array_get($user, 'email'). '</td>';
      $trs .= '</tr>';
}

echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Email</th>
     
    </tr>
  </thead>
  <tbody>
    '. $trs.'
  </tbody>
</table>';