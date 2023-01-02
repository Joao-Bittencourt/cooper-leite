<?php


foreach ($users as $user) {
    echo array_get($user, 'id');
    echo array_get($user, 'email2', 'default');
}