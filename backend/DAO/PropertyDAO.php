<?php
require_once __DIR__ . '/../config.php';

class PropertyDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM properties");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM properties WHERE property_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO properties (title, city, type, details, image, price, agent_id)
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['city'],
            $data['type'],
            $data['details'],
            $data['image'],
            $data['price'],
            $data['agent_id']
        ]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE properties SET title=?, city=?, type=?, details=?, image=?, price=?, agent_id=? WHERE property_id=?");
        $stmt->execute([
            $data['title'],
            $data['city'],
            $data['type'],
            $data['details'],
            $data['image'],
            $data['price'],
            $data['agent_id'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM properties WHERE property_id = ?");
        $stmt->execute([$id]);
    }
}
