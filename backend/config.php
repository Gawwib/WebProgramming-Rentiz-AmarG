<?php
$host = 'localhost';
$db   = 'rentiz';
$user = 'root';
$pass = '123';  

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
