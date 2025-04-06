<?php
require_once __DIR__ . '/../dao/AgentProfileDAO.php';

Flight::route('GET /agents', function () {
    $dao = new AgentProfileDAO(Flight::get('pdo'));
    Flight::json($dao->getAll());
});

Flight::route('GET /agents/@id', function ($id) {
    $dao = new AgentProfileDAO(Flight::get('pdo'));
    Flight::json($dao->getByAgentId($id));
});

Flight::route('POST /agents', function () {
    $data = Flight::request()->data->getData();
    $dao = new AgentProfileDAO(Flight::get('pdo'));
    $dao->create($data);
    Flight::json(['message' => 'Agent profile created']);
});

Flight::route('PUT /agents/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $dao = new AgentProfileDAO(Flight::get('pdo'));
    $dao->update($id, $data['license_number']);
    Flight::json(['message' => 'Agent profile updated']);
});

Flight::route('DELETE /agents/@id', function ($id) {
    $dao = new AgentProfileDAO(Flight::get('pdo'));
    $dao->delete($id);
    Flight::json(['message' => 'Agent profile deleted']);
});
