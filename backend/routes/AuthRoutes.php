<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register a new user",
 *     tags={"auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "email", "password"},
 *             @OA\Property(property="first_name", type="string", example="Jane"),
 *             @OA\Property(property="last_name", type="string", example="Doe"),
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123"),
 *             @OA\Property(property="phone_number", type="string", example="1234567890"),
 *             @OA\Property(property="role", type="string", enum={"client", "agent"}, example="client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully"
 *     )
 * )
 */
Flight::route('POST /auth/register', function () {
    $data = Flight::request()->data->getData();

    try {
        $response = Flight::authService()->register($data);
        Flight::json($response);
    } catch (Exception $e) {
        Flight::halt(500, $e->getMessage());
    }
});

/**
 * @OA\Post(
 *     path="/auth/login",
 *     summary="Login and get JWT token",
 *     tags={"auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns user info and JWT token"
 *     )
 * )
 */
Flight::route('POST /auth/login', function () {
    $data = Flight::request()->data->getData();

    try {
        $response = Flight::authService()->login($data);
        Flight::json($response); 
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage()); 
    }
});

/**
 * @OA\Get(
 *     path="/me",
 *     tags={"Auth"},
 *     summary="Get current logged-in user info",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Authenticated user info"
 *     )
 * )
 */
Flight::route('GET /me', function () {
    AuthMiddleware::handle();

    $user = Flight::get('user');
    Flight::json(['user' => $user]);
});
