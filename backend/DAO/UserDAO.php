<?php
require_once __DIR__ . '/../config.php';

class UserDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, role)
                                      VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['phone_number'],
            $data['role']
        ]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ? WHERE user_id = ?");
        $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone_number'],
            $data['role'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
    }
}
