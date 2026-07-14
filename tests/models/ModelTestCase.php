<?php

namespace CooperLeite\Tests\models;

use PHPUnit\Framework\TestCase;
use core\Database;

class ModelTestCase extends TestCase
{
    public function setUp(): void
    {
        include_once dirname(__DIR__, 2) . '/src/core/basics.php';
        $_ENV['ENVIRONMENT'] = 'TEST';

        $database = new Database();
        $capsule = $database::getCapsule();

        $capsule->getDatabaseManager()->purge();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $schema = $capsule->getConnection()->getSchemaBuilder();

        $schema->create('groups', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        $schema->create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->integer('group_id')->default(0);
            $table->integer('cliente_id')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        $schema->create('produtos', function ($table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->string('unidade')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        $schema->create('clientes', function ($table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->string('tipo_pessoa')->nullable();
            $table->string('papel')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        $schema->create('pessoa_fisicas', function ($table) {
            $table->increments('id');
            $table->integer('cliente_id')->nullable();
            $table->string('nome_civil')->nullable();
            $table->dateTime('dt_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        $schema->create('pessoa_juridicas', function ($table) {
            $table->increments('id');
            $table->integer('cliente_id')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('razao_social')->nullable();
            $table->timestamps();
        });
    }
}
