<?php
require_once __DIR__ . '/../DAO/UserDAO.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDAO(Flight::get('pdo'));
    }

    public function register($data) {
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password']) || empty($data['role'])) {
            throw new Exception("Missing required fields");
        }

        // Validate role
        if (!in_array($data['role'], ['agent', 'client'])) {
            throw new Exception("Invalid role");
        }

        // Check if email already exists
        $existingUser = $this->userDao->get_by_email($data['email']);
        if ($existingUser) {
            throw new Exception("Email already registered");
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Create user
        $user = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => $hashedPassword,
            'phone_number' => $data['phone_number'] ?? null,
            'role'       => $data['role']
        ];

        $user_id = $this->userDao->create($user);
        $createdUser = $this->userDao->get($user_id);

        return [
            'user' => $createdUser,
            'message' => 'Registration successful'
        ];
    }

    public function login($data) {
        if (empty($data['email']) || empty($data['password'])) {
            throw new Exception("Missing email or password");
        }

        $user = $this->userDao->get_by_email($data['email']);
        if (!$user || !password_verify($data['password'], $user['password'])) {
            throw new Exception("Invalid credentials");
        }

        $payload = [
            'user_id' => $user['user_id'],
            'email'   => $user['email'],
            'role'    => $user['role'],
            'exp'     => time() + (60 * 60 * 24) // 1 day expiration
        ];

        $jwt = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

        return [
            'token' => $jwt,
            'user' => [
                'user_id' => $user['user_id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'role' => $user['role']
            ]
        ];
    }
}
