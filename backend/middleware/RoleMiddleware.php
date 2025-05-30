<?php

class RoleMiddleware {
    public static function allow($allowed_roles = []) {
        return function () use ($allowed_roles) {
            $user = Flight::get('user');

            if (!$user || !isset($user['role'])) {
                Flight::json(['error' => 'User role not found'], 403);
                exit;
            }

            if (!in_array($user['role'], $allowed_roles)) {
                Flight::json(['error' => 'Access denied: insufficient permissions'], 403);
                exit;
            }
        };
    }
}
