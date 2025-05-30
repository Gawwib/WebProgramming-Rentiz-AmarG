<?php
class AuthDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function get_user_by_email($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert_user($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, role)
                                      VALUES (:first_name, :last_name, :email, :password, :phone_number, :role)");
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone_number' => $data['phone_number'] ?? null,
            'role' => $data['role'] ?? 'client'
        ]);

        $data['user_id'] = $this->conn->lastInsertId();
        return $data;
    }
}
