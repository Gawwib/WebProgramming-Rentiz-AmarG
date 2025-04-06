<?php
require_once __DIR__ . '/../DAO/UserDAO.php';

Flight::route('GET /users', function() {
    $dao = new UserDAO(Flight::get('pdo'));
    Flight::json($dao->getAll());
});

Flight::route('GET /users/@id', function($id) {
    $dao = new UserDAO(Flight::get('pdo'));
    Flight::json($dao->getById($id));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    $dao = new UserDAO(Flight::get('pdo'));
    $id = $dao->create($data);
    Flight::json(["user_id" => $id]);
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    $dao = new UserDAO(Flight::get('pdo'));
    $dao->update($id, $data);
    Flight::json(["message" => "User updated"]);
});

Flight::route('DELETE /users/@id', function($id) {
    $dao = new UserDAO(Flight::get('pdo'));
    $dao->delete($id);
    Flight::json(["message" => "User deleted"]);
});
