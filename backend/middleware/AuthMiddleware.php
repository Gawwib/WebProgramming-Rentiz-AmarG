<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public static function handle() {
        $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];

        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authHeader) {
            Flight::json(['error' => '🔒 Token required'], 401);
            exit;
        }

        $token = trim($authHeader); 

        try {
            $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('user', (array) $decoded); 
        } catch (Exception $e) {
            Flight::json(['error' => '❌ Invalid or expired token: ' . $e->getMessage()], 401);
            exit;
        }
    }
}

