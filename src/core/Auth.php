<?php

namespace core;

use CooperLeite\models\User;

class Auth {

    private static $key = '1234';

    public static function login(User $User, array $data) {
                
        $user = $User::where([
                    [
                        'login', '=', $data['login']
                    ],
                    [
                        'password', '=', $data['password']
                    ]
                ])->first();

        if (empty($user)) {
            throw new \Exception('Email ou senha inválidos');
        }

        // Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'id' => $user->id,
            'email' => $user->email,
            'group_id' => $user->group_id,
        ];

        $header = json_encode($header);
        $payload = json_encode($payload);

        //Base 64
        $header = self::base64UrlEncode($header);
        $payload = self::base64UrlEncode($payload);

        //Sign
        $sign = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
        $sign = self::base64UrlEncode($sign);

        //Token
        $token = $header . '.' . $payload . '.' . $sign;

        return $token;
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function checkAuth() {
        $http_header = apache_request_headers();

        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            $bearer = explode(' ', $http_header['Authorization']);

            if (count($bearer) < 2) {
//                throw new Exception('Erro ao ler o token.');
                return false;
            }
        }

        if (isset($_SESSION['Auth']['jwt']) && $_SESSION['Auth']['jwt'] != null) {
            $bearer[1] = $_SESSION['Auth']['jwt'];
        }

        if (empty($bearer[1])) {
             return false;
        }

        $token = explode('.', $bearer[1]);

        if (count($token) < 3) {
             return false;
//            throw new Exception('Erro ao ler o token.');
        }

        $header = $token[0];
        $payload = $token[1];
        $sign = $token[2];

        // Conferindo a assinatura
        $valid = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
        $valid = self::base64UrlEncode($valid);

        if ($sign === $valid) {
            return true;
        }

        return false;
    }
    
    public static function checkAuthorization(string $controller, string $action, ?bool $isAuth = null): bool {
        
        if (is_null($isAuth)) {
            $isAuth = self::checkAuth();
        }
        
        if ($controller == 'Users' && ($action == 'login' || $action == 'auth')) {
            return true;
        }
        
        return $isAuth;   
    }

    private static function base64UrlEncode($data) {
        $b64 = base64_encode($data);

        if ($b64 === false) {
            return false;
        }

        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }

}
