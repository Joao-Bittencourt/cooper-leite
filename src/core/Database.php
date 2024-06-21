<?php

namespace core;

use CooperLeite\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static $capsule = null;
    public static $config;

    public function __construct()
    {
        $this->inicializeCapsule();
    }

    public static function getCapsule(): Capsule
    {
        self::inicializeCapsule();

        return self::$capsule;
    }

    public static function inicializeCapsule(): void
    {
        if (is_null(self::$capsule)) {
            self::inicializeConfig();
            
            self::$capsule = new Capsule();
            self::$capsule->addConnection([
                "driver" => self::$config->DB_DRIVER,
                "host" => self::$config->DB_HOST,
                "port" => self::$config->DB_PORT,
                "database" => self::$config->DB_DATABASE,
                "username" => self::$config->DB_USER,
                "password" => self::$config->DB_PASS
            ]);

            self::$capsule->setAsGlobal();
            self::$capsule->bootEloquent();
//            self::$capsule->connection()->enableQueryLog();
//            debug(\Illuminate\Database\Capsule\Manager::getQueryLog());
        }
    }

    public static function inicializeConfig(?Config $configuration = null): void
    {
        self::$config = $configuration ?? new Config();
    }
}
