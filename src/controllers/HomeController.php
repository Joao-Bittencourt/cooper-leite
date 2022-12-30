<?php

namespace CooperLeite\controllers;

use \core\Controller;

class HomeController extends Controller {

    public function index() {
        $this->layout('home');
    }

    public function sobre() {
        $this->render('sobre');
    }

}
