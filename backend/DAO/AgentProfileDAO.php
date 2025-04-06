<?php
require_once __DIR__ . '/../config.php';

class AgentProfileDAO {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM agentprofiles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByAgentId($agent_id) {
        $stmt = $this->conn->prepare("SELECT * FROM agentprofiles WHERE agent_id = ?");
        $stmt->execute([$agent_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO agentprofiles (agent_id, license_number) VALUES (?, ?)");
        $stmt->execute([
            $data['agent_id'],
            $data['license_number']
        ]);
    }

    public function update($agent_id, $license) {
        $stmt = $this->conn->prepare("UPDATE agentprofiles SET license_number = ? WHERE agent_id = ?");
        $stmt->execute([$license, $agent_id]);
    }

    public function delete($agent_id) {
        $stmt = $this->conn->prepare("DELETE FROM agentprofiles WHERE agent_id = ?");
        $stmt->execute([$agent_id]);
    }
}
