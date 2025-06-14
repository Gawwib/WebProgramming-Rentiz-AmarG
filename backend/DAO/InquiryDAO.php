<?php
require_once __DIR__ . '/../config.php';

class InquiryDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO property_inquiries (property_id, user_id, question) VALUES (?, ?, ?)");
        $stmt->execute([$data['property_id'], $data['user_id'], $data['question']]);

        // Return the newly inserted inquiry
        $id = $this->conn->lastInsertId();
        return $this->getById($id); 
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM property_inquiries");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM property_inquiries WHERE inquiry_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByProperty($property_id) {
        $stmt = $this->conn->prepare("SELECT * FROM property_inquiries WHERE property_id = ?");
        $stmt->execute([$property_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO property_inquiries (property_id, user_id, question, answer)
                                      VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['property_id'],
            $data['user_id'],
            $data['question'],
            $data['answer'] ?? null
        ]);
        return $this->conn->lastInsertId();
    }
    
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE property_inquiries SET question = ?, answer = ? WHERE inquiry_id = ?");
        $stmt->execute([
            $data['question'] ?? null,
            $data['answer'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM property_inquiries WHERE inquiry_id = ?");
        $stmt->execute([$id]);
    }
}
