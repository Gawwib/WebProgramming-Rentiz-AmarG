<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Get(
 *     path="/appointments",
 *     tags={"Appointments"},
 *     summary="Get all appointments",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of appointments"
 *     )
 * )
 */
Flight::route('GET /appointments', function () {
    AuthMiddleware::handle();
    Flight::json(Flight::appointmentService()->get_all());
});

/**
 * @OA\Get(
 *     path="/appointments/{id}",
 *     tags={"Appointments"},
 *     summary="Get appointment by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment details"
 *     )
 * )
 */
Flight::route('GET /appointments/@id', function ($id) {
    AuthMiddleware::handle();

    $user = Flight::get('user');
    $appointment = Flight::appointmentService()->get_by_id($id);

    // Client can only view their own appointment
    if ($user['role'] === 'client' && $appointment['user_id'] != $user['user_id']) {
        Flight::json(['error' => 'Access denied'], 403);
        return;
    }

    Flight::json($appointment);
});

/**
 * @OA\Post(
 *     path="/appointments",
 *     tags={"Appointments"},
 *     summary="Create a new appointment",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"property_id", "user_id", "appointment_date", "appointment_time"},
 *             @OA\Property(property="property_id", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=5),
 *             @OA\Property(property="appointment_date", type="string", format="date", example="2025-06-01"),
 *             @OA\Property(property="appointment_time", type="string", format="time", example="14:30:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment created"
 *     )
 * )
 */
Flight::route('POST /appointments', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent', 'client'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::appointmentService()->add($data));
});

/**
 * @OA\Delete(
 *     path="/appointments/{id}",
 *     tags={"Appointments"},
 *     summary="Delete an appointment",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment deleted"
 *     )
 * )
 */
Flight::route('DELETE /appointments/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::appointmentService()->delete($id));
});
