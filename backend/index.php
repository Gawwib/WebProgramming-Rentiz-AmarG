<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/middleware/RoleMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// DAO
require_once __DIR__ . '/DAO/UserDAO.php';
require_once __DIR__ . '/DAO/PropertyDAO.php';
require_once __DIR__ . '/DAO/AppointmentDAO.php';
require_once __DIR__ . '/DAO/InquiryDAO.php';
require_once __DIR__ . '/DAO/AuthDAO.php';
require_once __DIR__ . '/DAO/AgentProfileDAO.php';

// Services
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/PropertyService.php';
require_once __DIR__ . '/services/AppointmentService.php';
require_once __DIR__ . '/services/InquiryService.php';
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/services/AgentProfileService.php';

// Set PDO globally
Flight::set('pdo', $pdo);

// Register services
Flight::register('userService', 'UserService', [new UserDAO(Flight::get('pdo'))]);
Flight::register('propertyService', 'PropertyService', [new PropertyDAO(Flight::get('pdo'))]);
Flight::register('appointmentService', 'AppointmentService', [new AppointmentDAO(Flight::get('pdo'))]);
Flight::register('inquiryService', 'InquiryService', [new InquiryDAO(Flight::get('pdo'))]);
Flight::register('agentProfileService', 'AgentProfileService', [new AgentProfileDAO(Flight::get('pdo'))]);
Flight::register('authService', 'AuthService');

// Routes
require_once __DIR__ . '/routes/users.php';
require_once __DIR__ . '/routes/properties.php';
require_once __DIR__ . '/routes/appointments.php';
require_once __DIR__ . '/routes/inquiries.php';
require_once __DIR__ . '/routes/AuthRoutes.php';
require_once __DIR__ . '/routes/agents.php';

// Debug route
Flight::route('GET /debug-user', function () {
    AuthMiddleware::handle(); 
    $user = Flight::get('user');
    if (!$user) {
        Flight::json(['error' => 'User not found'], 401);
    } else {
        Flight::json(['user' => $user]);
    }
});

// Test route
Flight::route('GET /test', function () {
    echo "🚀 FlightPHP is working!";
});

// 404 handler
Flight::map('notFound', function () {
    echo '🚫 Custom 404: Route not found by FlightPHP.';
});

Flight::start();
