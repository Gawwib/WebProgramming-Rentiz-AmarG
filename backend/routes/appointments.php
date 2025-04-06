<?php
require_once __DIR__ . '/../dao/AppointmentDAO.php';

Flight::route('GET /appointments', function () {
    $dao = new AppointmentDAO(Flight::get('pdo'));
    Flight::json($dao->getAll());
});

Flight::route('GET /appointments/@id', function ($id) {
    $dao = new AppointmentDAO(Flight::get('pdo'));
    Flight::json($dao->getById($id));
});

Flight::route('POST /appointments', function () {
    $data = Flight::request()->data->getData();
    $dao = new AppointmentDAO(Flight::get('pdo'));
    $id = $dao->create($data);
    Flight::json(['appointment_id' => $id]);
});

Flight::route('DELETE /appointments/@id', function ($id) {
    $dao = new AppointmentDAO(Flight::get('pdo'));
    $dao->delete($id);
    Flight::json(['message' => 'Appointment deleted']);
});
