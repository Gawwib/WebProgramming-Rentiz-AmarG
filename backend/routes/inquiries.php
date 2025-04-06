<?php
require_once __DIR__ . '/../dao/InquiryDAO.php';

Flight::route('GET /inquiries', function () {
    $dao = new InquiryDAO(Flight::get('pdo'));
    Flight::json($dao->getAll());
});

Flight::route('GET /inquiries/@id', function ($id) {
    $dao = new InquiryDAO(Flight::get('pdo'));
    Flight::json($dao->getById($id));
});

Flight::route('GET /inquiries/property/@property_id', function ($property_id) {
    $dao = new InquiryDAO(Flight::get('pdo'));
    Flight::json($dao->getByProperty($property_id));
});

Flight::route('POST /inquiries', function () {
    $data = Flight::request()->data->getData();
    $dao = new InquiryDAO(Flight::get('pdo'));
    $id = $dao->create($data);
    Flight::json(['inquiry_id' => $id]);
});

Flight::route('DELETE /inquiries/@id', function ($id) {
    $dao = new InquiryDAO(Flight::get('pdo'));
    $dao->delete($id);
    Flight::json(['message' => 'Inquiry deleted']);
});
