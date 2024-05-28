<?php
namespace gift\appli\app\utils;

class CsrfService {
    public static function generate(){
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        $_SESSION['giftbox_csrf_token'] = $token;
        return $token;
    }

    public static function check($token){
        if (!isset($_SESSION['giftbox_csrf_token']) || $_SESSION['giftbox_csrf_token'] !== $token) {
            throw new \Exception('CSRF token verification failed');
        }

        unset($_SESSION['giftbox_csrf_token']);
    }
}