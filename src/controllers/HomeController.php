<?php

namespace CooperLeite\controllers;

use core\Controller;

class HomeController extends AppController
{
    public function __construct()
    {
        $this->layout = 'home';
    }

    public function home()
    {
        // method only to autoRender view
    }
}
