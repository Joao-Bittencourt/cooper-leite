<?php

$message = $message ?? 'Erro inexperado.';

switch (substr($code, 0, 1)) {
    case '4':
        $type = 'warning';
        break;
    case '5':
    default :
        $message = 'Erro inexperado.';
        $type = 'danger';
}

echo sprintf('<div class="alert alert-%s">%s</div>',
        $type,
        $message,
);
