<?php
$host = 'localhost';
$db   = 'rentiz';
$user = 'root';
$pass = '';


class Config {
    public static function JWT_SECRET() {
        return '2024stuibueduba2025';
    }
}

// ✅ Optional: basic logging + centralized error handler
set_error_handler(function ($severity, $message, $file, $line) {
    error_log("[$severity] $message in $file on line $line\n", 3, __DIR__ . '/error.log');
    http_response_code(500);
    echo json_encode(["error" => "An internal server error occurred."]);
    exit;
});

set_exception_handler(function ($exception) {
    error_log("[Exception] " . $exception->getMessage() . "\n", 3, __DIR__ . '/error.log');
    http_response_code(500);
    echo json_encode(["error" => "An internal server error occurred."]);
    exit;
});

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("[PDOException] " . $e->getMessage() . "\n", 3, __DIR__ . '/error.log');
    die("Database connection failed.");
}
?>
