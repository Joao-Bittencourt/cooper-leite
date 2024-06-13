<?php

namespace CooperLeite\controllers;

use core\Controller;

class ErrorController extends AppController
{
    public function index()
    {
        $this->render('404');
    }
}
