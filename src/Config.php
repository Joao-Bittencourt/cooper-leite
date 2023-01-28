<?php

namespace CooperLeite;

class Config {

    const BASE_DIR = '';
    const DB_DRIVER = '';
    const DB_HOST = '';
    const DB_PORT = '';
    const DB_DATABASE = '';
    const DB_USER = '';
    const DB_PASS = '';
    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';

    public function __construct() {

        $this->DB_DRIVER = isset($_ENV['DB_DRIVER']) ? $_ENV['DB_DRIVER'] : 'mysql';
        $this->DB_HOST = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost';
        $this->DB_PORT = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : '3306';
        $this->DB_DATABASE = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'cooper_leite';
        $this->DB_USER = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : 'root';
        $this->DB_PASS = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : null;

    }

}
