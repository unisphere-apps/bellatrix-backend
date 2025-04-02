<?php
require_once '../models/User.php';
require_once 'Response.php';

class Auth {
    public static function check() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? null;

        if (!$authHeader || substr($authHeader, 0, 7) !== "Bearer ") {
            Response::json(["error" => "Accès refusé."], 401);
        }

        $token = trim(str_replace("Bearer", "", $authHeader));

        $user = (new User())->verifyToken($token);
        if (!$user) {
            Response::json(["error" => "Token invalide"], 401);
        }

        return $user; // tu peux l’utiliser dans le contrôleur si besoin
    }
}
