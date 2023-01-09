<?php

namespace core;

use \core\Database;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    protected static $capsule;
    public $erros;
    
    public function __construct() {
        new Database();
        self::$capsule = Database::$capsule;
    }
 

}
