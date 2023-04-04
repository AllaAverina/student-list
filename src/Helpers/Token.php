<?php

namespace StudentList\Helpers;

class Token
{
    public static function getToken(): string
    {
        $token = $_COOKIE['formToken'] ?? md5(random_bytes(16));
        setcookie('formToken', $token, ['expires' => strtotime('+1 hour'), 'httponly' => true, 'samesite' => 'Strict']);
        return $token;
    }
}
