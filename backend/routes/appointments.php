<?php

/**
 * @OA\Get(
 *     path="/appointments",
 *     tags={"Appointments"},
 *     summary="Get all appointments",
 *     @OA\Response(
 *         response=200,
 *         description="List of appointments"
 *     )
 * )
 */
Flight::route('GET /appointments', function () {
    Flight::json(Flight::appointmentService()->get_all());
});

/**
 * @OA\Get(
 *     path="/appointments/{id}",
 *     tags={"Appointments"},
 *     summary="Get appointment by ID",
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
    Flight::json(Flight::appointmentService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/appointments",
 *     tags={"Appointments"},
 *     summary="Create a new appointment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="property_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="appointment_time", type="string", example="2025-05-10 14:00:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment created"
 *     )
 * )
 */
Flight::route('POST /appointments', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::appointmentService()->add($data));
});

/**
 * @OA\Delete(
 *     path="/appointments/{id}",
 *     tags={"Appointments"},
 *     summary="Delete an appointment",
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
    Flight::json(Flight::appointmentService()->delete($id));
});
