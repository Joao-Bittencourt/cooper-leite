<?php

namespace core;

use \CooperLeite\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    public static $capsule;

    public function __construct() {

        self::$capsule = new Capsule();
        self::$capsule->addConnection([
            "driver" => Config::DB_DRIVER,
            "host" => Config::DB_HOST,
//            "port" => Config::DB_PORT,
            "database" => Config::DB_DATABASE,
            "username" => Config::DB_USER,
            "password" => Config::DB_PASS
        ]);
        self::$capsule->setAsGlobal();
        self::$capsule->bootEloquent();
    }
}
