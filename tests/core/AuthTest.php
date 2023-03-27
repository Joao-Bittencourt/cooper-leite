<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Auth;

class AuthTest extends TestCase {

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';

        include_once './src/core/basics.php';
    }

    public function test_check_auth_bearer() {
        $_SERVER['HTTP_Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertTrue($result);
        unset($_SERVER['HTTP_Authorization']);
    }
    
    public function test_check_auth_bearer_bearer_not_have_two_parts() {
        $_SERVER['HTTP_Authorization'] = 'BearereyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SERVER['HTTP_Authorization']);
    }
    
    public function test_check_auth_bearer_invalid() {
        $_SERVER['HTTP_Authorization'] = 'Bearer invalido_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SERVER['HTTP_Authorization']);
    }
    
    public function test_check_auth_session() {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertTrue($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_check_auth_invalido_session() {
        $_SESSION['Auth']['jwt'] = 'invalido_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_check_auth_invalido_session_sem_tres_parametros() {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';

        $result = Auth::checkAuth();

        $this->assertFalse($result);
        unset($_SESSION['Auth']['jwt']);
    }

    public function test_logout() {

        session_start();
        $_SESSION['Auth']['jwt'] = 'teste';
        Auth::logout();
        $this->assertEmpty($_SESSION);
    }

//    public function test_login() {
//        Revisar as dependencias para poder realizar teste unitario
//    }

    public function test_check_authorization() {

        $result = Auth::checkAuthorization('Users', 'login', true);
        $this->assertTrue($result);
    }

    public function test_check_authorization_auth_null() {

        $result = Auth::checkAuthorization('Users', 'login', null);
        $this->assertTrue($result);
    }

}
