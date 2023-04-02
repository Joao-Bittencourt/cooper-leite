<?php

namespace core;

use \CooperLeite\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    public static $capsule = null;

    public function __construct() {
        $this->inicializeCapsule();
    }
    
    public static function getCapsule():Capsule {
        self::inicializeCapsule();
        
        return self::$capsule;
    }
    
    public static function inicializeCapsule(): void {
        
        if (is_null(self::$capsule)) {

            $Config = new Config();
            
            self::$capsule = new Capsule();
            self::$capsule->addConnection([
                "driver" => $Config->DB_DRIVER,
                "host" => $Config->DB_HOST,
                "port" => $Config->DB_PORT,
                "database" => $Config->DB_DATABASE,
                "username" => $Config->DB_USER,
                "password" => $Config->DB_PASS
            ]);

            self::$capsule->setAsGlobal();
            self::$capsule->bootEloquent();   
//            self::$capsule->connection()->enableQueryLog();
//            debug(\Illuminate\Database\Capsule\Manager::getQueryLog());
        }
    }

}
