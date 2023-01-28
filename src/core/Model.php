<?php

namespace core;

use \core\Database;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    protected static $capsule;
    public $validate;
    public $modelData;
    public $erros;

    public function __construct() {
        new Database();
        self::$capsule = Database::$capsule;
    }

    public function _save(Model $model) {

        $this->erros = Validate::execute($this->validate, $this->modelData);

        if (empty($this->erros)) {
            $model->save();
            return true;
        }
        
        return false;
    }
}
