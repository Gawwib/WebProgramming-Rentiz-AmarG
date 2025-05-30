<?php
require_once __DIR__ . '/../config.php';

class UserDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function get_all() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_by_email($email) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
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
        $fields = [];
        $values = [];

        // Dynamically build query from provided fields
        foreach ($data as $key => $value) {
            if (!empty($value) || $value === "0") { // allow falsy values like 0
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }

        // If no valid fields were provided, don't run update
        if (empty($fields)) {
            throw new Exception("No valid fields provided for update");
        }

        $values[] = $id;
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($values);
    }


    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
    }

    public function get($id) {
    return $this->getById($id);
}

}
