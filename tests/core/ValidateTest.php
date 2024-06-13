<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Validate;

class ValidateTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function test_execute()
    {
        $fields['campo'] = [
            'notEmpty' => [
                'message' => 'Nome deve ser preenchido.'
            ],
        ];
        $data['campo'] = 'a';

        $result = Validate::execute($fields, $data);

        $this->assertEmpty(Validate::$erros);
    }

    public function test_execute_with_error_message()
    {
        $fields['campo'] = [
            'notEmpty' => [
                'message' => 'Nome deve ser preenchido.'
            ],
        ];
        $data['campo'] = '';

        $result = Validate::execute($fields, $data);

        $this->assertEquals('Nome deve ser preenchido.', Validate::$erros['campo'][0]);
    }


    /**
     * @dataProvider ruleCustomProvider
     */
    public function test_rule_custom($check, $regexExpression, $expected)
    {
        $result = Validate::custom($check, $regexExpression);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider ruleNotEmptyProvider
     */
    public function test_rule_not_empty($check, $expected)
    {
        $result = Validate::notEmpty($check);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider ruleEqualToProvider
     */
    public function test_rule_equals_to($check, $equalsTo, $expected)
    {
        $result = Validate::equalTo($check, $equalsTo);

        $this->assertEquals($expected, $result);
    }

    // Providers

    public function ruleNotEmptyProvider()
    {
        return [
            [[], false],
            ['', false],
            [null, false],
            [['a'], false], // @ToDo: revisar este comportamento
            ['0', true],
            [0, true],
//            [false, true],
        ];
    }

    public function ruleEqualToProvider()
    {
        return [
            [[], [], true],
            [['a'], ['a'], true],
            [['a'], [0 => 'a'], true],
            [['a' => 'b'], ['a' => 'b'], true],
            ['', '', true],
            [null, null, true],
            [0, 0, true],
            [1, 1, true],
            ['0', '0', true],
            ['1', '1', true],
            [true, true, true],
            [false, false, true],
            [true, 1, false],
            [true, '1', false],
            [true, 'true', false],
            [false, 0, false],
            [false, null, false],
            [0, '0', false],
            [1, '1', false],
            ['1', 1, false],
//            [false, true],
        ];
    }

    public function ruleCustomProvider()
    {
        return [
           ['12345', '/(?<!\\S)\\d++(?!\\S)/', true],
           ['Text', '/(?<!\\S)\\d++(?!\\S)/', false],
           ['123.45', '/(?<!\\S)\\d++(?!\\S)/', false],
           ['missing regex', null, false],
           [null, null, false]
        ];
    }
}
