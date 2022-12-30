<?php

namespace CooperLeite\controllers;

use \core\Controller;

class ErrorController extends Controller {

    public function index() {
        $this->render('404');
    }

}
