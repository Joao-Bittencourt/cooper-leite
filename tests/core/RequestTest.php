<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Request;

class RequestTest extends TestCase
{
    public function setUp(): void
    {
        $_GET = [];
        $_POST = [];
    }

    public function test_create_request()
    {
        $request = new Request();
        $this->assertNotEmpty($request);
        $this->assertTrue(($request instanceof Request), 'Request deve ser uma instancia de core\Request');
    }

    public function test_request_get_url_empty()
    {
        $result = Request::getUrl();
        $this->assertEquals('/', $result);
    }

    public function test_get_data_post_empty()
    {
        $result = Request::getData();
        $this->assertEmpty($result);
    }

    public function test_get_data_post_not_empty()
    {
        $_POST['a'] = 'b';
        $result = Request::getData();
        $this->assertEquals(['a' => 'b'], $result);
    }

    public function test_get_method_get_method()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = Request::getMethod();
        $this->assertEquals('GET', $result);
    }

    public function test_get_request_data_get()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['a'] = 'b';

        $result = Request::getRequestData();
        $expected = ['a' => 'b'];

        $this->assertEquals($expected, $result);
    }

    public function test_get_request_data_post()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['a'] = 'b';

        $result = Request::getRequestData();
        $expected = ['a' => 'b'];

        $this->assertEquals($expected, $result);
    }

    public function test_get_url_various()
    {
        $_SERVER['REQUEST_URI'] = '/auth/user';
        $this->assertEquals('/auth/user', Request::getUrl());

        $_SERVER['REQUEST_URI'] = 'auth/user';
        $this->assertEquals('/auth/user', Request::getUrl());
        
        $_SERVER['REQUEST_URI'] = '/';
        $this->assertEquals('/', Request::getUrl());
    }

    public function test_get_request_data_delete_fallback()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_POST['deleted_id'] = 42;
        
        $result = Request::getRequestData();
        $this->assertEquals(['deleted_id' => 42], $result);
        unset($_POST['deleted_id']);
    }
}
