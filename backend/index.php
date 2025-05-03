<?php

require 'vendor/autoload.php';
require 'config.php';

Flight::set('pdo', $pdo);

// include DAO classes
require_once __DIR__ . '/DAO/UserDAO.php';
require_once __DIR__ . '/DAO/PropertyDAO.php';
require_once __DIR__ . '/DAO/AppointmentDAO.php';
require_once __DIR__ . '/DAO/InquiryDAO.php';
require_once __DIR__ . '/DAO/AgentProfileDAO.php';

// include service classes
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/PropertyService.php';
require_once __DIR__ . '/services/AppointmentService.php';
require_once __DIR__ . '/services/InquiryService.php';
require_once __DIR__ . '/services/AgentProfileService.php';

// register services
Flight::register('userService', 'UserService', [new UserDAO(Flight::get('pdo'))]);
Flight::register('propertyService', 'PropertyService', [new PropertyDAO(Flight::get('pdo'))]);
Flight::register('appointmentService', 'AppointmentService', [new AppointmentDAO(Flight::get('pdo'))]);
Flight::register('inquiryService', 'InquiryService', [new InquiryDAO(Flight::get('pdo'))]);
Flight::register('agentProfileService', 'AgentProfileService', [new AgentProfileDAO(Flight::get('pdo'))]);

//  routes
require_once __DIR__ . '/routes/users.php';
require_once __DIR__ . '/routes/properties.php';
require_once __DIR__ . '/routes/inquiries.php';
require_once __DIR__ . '/routes/appointments.php';
require_once __DIR__ . '/routes/agents.php';

// test & 404 routes
Flight::route('GET /test', function () {
    echo "🚀 FlightPHP is working!";
});

Flight::map('notFound', function () {
    echo '🚫 Custom 404: Route not found by FlightPHP.';
});

Flight::start();
