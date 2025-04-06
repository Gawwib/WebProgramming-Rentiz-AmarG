<?php
require_once __DIR__ . '/../config.php';

class AppointmentDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM appointments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO appointments (property_id, user_id, appointment_date, appointment_time)
                                      VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['property_id'],
            $data['user_id'],
            $data['appointment_date'],
            $data['appointment_time']
        ]);
        return $this->conn->lastInsertId();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
        $stmt->execute([$id]);
    }
}
