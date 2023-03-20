<?php

namespace CooperLeite\controllers;

use \core\Controller;

class HomeController extends AppController {
    
    function __construct() {
        $this->layout = 'home';       
    }
    public function home() {}
    
}
