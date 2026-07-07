<?php

namespace CooperLeite\Tests\models;

use CooperLeite\models\Group;

class GroupTest extends ModelTestCase
{
    public function test_salvar_empty_data()
    {
        $group = new Group();
        $result = $group->salvar([]);
        
        $this->assertFalse($result);
        $this->assertContains('Dados inexistentes para salvar.', $group->erros);
    }

    public function test_salvar_success()
    {
        $group = new Group();
        $result = $group->salvar(['name' => 'Admin Group', 'status' => 1]);
        
        $this->assertTrue($result);
        $this->assertEquals('Admin Group', $group->name);
        $this->assertEquals(1, $group->status);
        
        $dbRecord = Group::first();
        $this->assertEquals('Admin Group', $dbRecord->name);
    }

    public function test_group_has_many_users()
    {
        $group = new Group();
        $relation = $group->group();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
    }
}
