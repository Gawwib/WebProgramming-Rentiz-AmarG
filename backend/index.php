<?php
require 'vendor/autoload.php';
require 'config.php';

Flight::set('pdo', $pdo);

// Load all routes
require 'routes/users.php';
require 'routes/properties.php';
require 'routes/inquiries.php';
require 'routes/appointments.php';
require 'routes/agents.php';

Flight::route('GET /test', function() {
    echo "🚀 FlightPHP is working!";
});

Flight::map('notFound', function(){
    echo '🚫 Custom 404: Route not found by FlightPHP.';
});


Flight::start();

