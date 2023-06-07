<?php

namespace core;

use \core\Database;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    protected static $capsule;
    public $validate = [];
    public $modelData = [];
    public $erros;

    public function __construct() {
        self::$capsule = Database::getCapsule();
    }

    public function _save($update = false) {

        $this->erros = Validate::execute($this->validate, $this->modelData, $this);
        if (empty($this->erros)) {
               
            if ($update !== false) {
                $this->exists = true;
            }
            
            return $this->save();
        }
    
        return false;
    }
    
    public function _update() {
  
        $this->erros = Validate::execute($this->validate, $this->modelData, $this);

        if (empty($this->erros)) {
            return $this->update();
        }
        
        return false;
    }
}
