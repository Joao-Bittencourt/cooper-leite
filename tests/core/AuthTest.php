<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Auth;

class AuthTest extends TestCase
{
    public function setUp(): void
    {
        $_SERVER['ENVIRONMENT'] = 'TEST';
        $_ENV['ENVIRONMENT'] = 'TEST';

        include_once './src/core/basics.php';

        $database = new \core\Database();
        $capsule = $database::getCapsule();
        $capsule->getDatabaseManager()->purge();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $capsule->getConnection()->getSchemaBuilder()->create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->integer('group_id')->nullable();
        });

        $capsule->getConnection()->table('users')->insert([
            'id' => 1,
            'email' => 'email@email.com',
            'login' => 'email@email.com',
            'password' => 'email@email.com',
            'group_id' => 1
        ]);

        $capsule->getConnection()->table('users')->insert([
            'id' => 2,
            'email' => 'other@email.com',
            'login' => 'other@email.com',
            'password' => 'email@email.com',
            'group_id' => 2
        ]);

        $_SESSION = [];
    }

    public function test_check_auth_bearer()
    {
        $_SERVER['HTTP_Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertTrue($result);
        unset($_SERVER['HTTP_Authorization']);
    }

    public function test_check_auth_bearer_bearer_not_have_two_parts()
    {
        $_SERVER['HTTP_Authorization'] = 'BearereyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SERVER['HTTP_Authorization']);
    }

    public function test_check_auth_bearer_invalid()
    {
        $_SERVER['HTTP_Authorization'] = 'Bearer invalido_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SERVER['HTTP_Authorization']);
    }

    public function test_check_auth_session()
    {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertTrue($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_check_auth_invalido_session()
    {
        $_SESSION['Auth']['jwt'] = 'invalido_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_check_auth_invalido_session_sem_tres_parametros()
    {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $sessionActive = (session_status() === PHP_SESSION_ACTIVE);
        $_SESSION['Auth']['jwt'] = 'teste';
        Auth::logout();
        $this->assertEmpty($_SESSION);
        if ($sessionActive) {
            $this->assertEquals(PHP_SESSION_NONE, session_status());
        }
    }

    public function test_login()
    {
        $data = [
            'login' => 'email@email.com',
            'password' => 'email@email.com'
        ];

        $user = new \CooperLeite\models\User();
        $result = Auth::login($user, $data);

        $this->assertNotEmpty($result);

        // Verify structure and signature validation
        $_SERVER['HTTP_Authorization'] = 'Bearer ' . $result;
        $this->assertTrue(Auth::checkAuth());
        unset($_SERVER['HTTP_Authorization']);

        // Assert exact header and payload values
        $parts = explode('.', $result);
        $this->assertCount(3, $parts);

        $header = json_decode(base64_decode($parts[0]), true);
        $this->assertEquals('JWT', $header['typ'] ?? null);
        $this->assertEquals('HS256', $header['alg'] ?? null);

        $payload = json_decode(base64_decode($parts[1]), true);
        $this->assertEquals(1, $payload['id'] ?? null);
        $this->assertEquals('email@email.com', $payload['email'] ?? null);
        $this->assertEquals(1, $payload['group_id'] ?? null);
    }

    public function test_login_success_specific_user()
    {
        $data = [
            'login' => 'other@email.com',
            'password' => 'email@email.com'
        ];
        $user = new \CooperLeite\models\User();
        $token = Auth::login($user, $data);
        $this->assertNotEmpty($token);

        // Decode the token and assert it belongs to id = 2
        $parts = explode('.', $token);
        $payload = json_decode(base64_decode($parts[1]), true);
        $this->assertEquals(2, $payload['id']);
        $this->assertEquals('other@email.com', $payload['email']);
        $this->assertEquals(2, $payload['group_id']);
    }

    public function test_login_invalid()
    {
        $data = [
            'login' => 'email@email.com',
            'password' => 'invalido'
        ];

        $user = new \CooperLeite\models\User();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email ou senha inválidos');
        Auth::login($user, $data);
    }

    public function test_check_auth_none()
    {
        $result = Auth::checkAuth();
        $this->assertFalse($result);
    }

    public function test_check_authorization()
    {
        $result = Auth::checkAuthorization('Users', 'login', true);
        $this->assertTrue($result);
    }

    public function test_check_authorization_auth_null()
    {
        $result = Auth::checkAuthorization('Users', 'login', null);
        $this->assertTrue($result);
    }

    public function test_check_authorization_auth_null_restricted()
    {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';
        $result = Auth::checkAuthorization('Restricted', 'index', null);
        $this->assertTrue($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_check_authorization_allowed_controller_restricted_action()
    {
        $result = Auth::checkAuthorization('Users', 'restrictedAction', false);
        $this->assertFalse($result);
    }
}
