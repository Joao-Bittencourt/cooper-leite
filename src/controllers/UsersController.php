<?php

namespace CooperLeite\controllers;

use \core\Controller;
use CooperLeite\models\User;

class UsersController extends Controller {

    public function index() {
         $User = new User();
        
        $this->data['users'] = $User->select([
            'id',
            'email'
        ])->get();
          
    }
    

    public function cadastrar() {}
            
    public function store() {}
        
}
