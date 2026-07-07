<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Model;
use core\Database;

class TestModel extends Model
{
    protected $table = 'test_models';
    public $timestamps = false;
    protected $fillable = ['id', 'name'];

    public $validate = [
        'name' => [
            'notEmpty' => [
                'message' => 'Name cannot be empty.'
            ]
        ]
    ];
}

class ModelTest extends TestCase
{
    public function setUp(): void
    {
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

        $capsule->getConnection()->getSchemaBuilder()->create('test_models', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });
    }

    public function test_save_fails_validation()
    {
        $model = new TestModel();
        $model->modelData = ['name' => ''];

        $result = $model->_save();

        $this->assertFalse($result);
        $this->assertNotEmpty($model->erros);
        $this->assertEquals('Name cannot be empty.', $model->erros['name'][0]);
    }

    public function test_save_succeeds_insert()
    {
        $model = new TestModel();
        $model->name = 'Valid Name';
        $model->modelData = ['name' => 'Valid Name'];

        $result = $model->_save(false);

        $this->assertTrue($result);
        $this->assertEmpty($model->erros);
        
        $dbRecord = TestModel::first();
        $this->assertNotEmpty($dbRecord);
        $this->assertEquals('Valid Name', $dbRecord->name);
    }

    public function test_save_succeeds_update()
    {
        $model = new TestModel();
        $model->name = 'Old Name';
        $model->save();

        $model->modelData = ['name' => 'New Name'];
        $model->name = 'New Name';
        
        $result = $model->_save(true);

        $this->assertTrue($result);
        $this->assertEmpty($model->erros);
        
        $dbRecord = TestModel::find($model->id);
        $this->assertEquals('New Name', $dbRecord->name);
    }

    public function test_update_fails_validation()
    {
        $model = new TestModel();
        $model->name = 'Old Name';
        $model->save();

        $model->modelData = ['name' => ''];
        $result = $model->_update();

        $this->assertFalse($result);
        $this->assertNotEmpty($model->erros);
    }

    public function test_update_succeeds()
    {
        $model = new TestModel();
        $model->name = 'Old Name';
        $model->save();

        $model->modelData = ['name' => 'Updated Name'];
        $model->name = 'Updated Name';
        
        $result = $model->_update();

        $this->assertTrue($result);
        
        $dbRecord = TestModel::find($model->id);
        $this->assertEquals('Updated Name', $dbRecord->name);
    }
}
