<?php
require_once __DIR__ . '/../dao/PropertyDAO.php';

Flight::route('GET /properties', function () {
    $dao = new PropertyDAO(Flight::get('pdo'));
    Flight::json($dao->getAll());
});

Flight::route('GET /properties/@id', function ($id) {
    $dao = new PropertyDAO(Flight::get('pdo'));
    Flight::json($dao->getById($id));
});

Flight::route('POST /properties', function () {
    $data = Flight::request()->data->getData();
    $dao = new PropertyDAO(Flight::get('pdo'));
    $id = $dao->create($data);
    Flight::json(['property_id' => $id]);
});

Flight::route('PUT /properties/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $dao = new PropertyDAO(Flight::get('pdo'));
    $dao->update($id, $data);
    Flight::json(['message' => 'Property updated']);
});

Flight::route('DELETE /properties/@id', function ($id) {
    $dao = new PropertyDAO(Flight::get('pdo'));
    $dao->delete($id);
    Flight::json(['message' => 'Property deleted']);
});
