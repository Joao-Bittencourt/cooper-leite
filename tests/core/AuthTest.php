<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Auth;

class AuthTest extends TestCase {

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';
        
        include_once './src/core/basics.php';
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

}
