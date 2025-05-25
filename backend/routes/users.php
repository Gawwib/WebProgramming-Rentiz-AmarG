<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Get all users (agent only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     )
 * )
 */
Flight::route('GET /users', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::userService()->get_all());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="User data"),
 *     @OA\Response(response=404, description="User not found")
 * )
 */
Flight::route('GET /users/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent', 'client'])();

    $user = Flight::get('user');

    if ($user['role'] === 'client' && $user['user_id'] != $id) {
        Flight::json(['error' => 'Access denied'], 403);
        return;
    }

    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update user info (self or agent)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string", example="Updated"),
 *             @OA\Property(property="last_name", type="string", example="Name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="phone_number", type="string", example="1234567890"),
 *             @OA\Property(property="role", type="string", example="client")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User updated")
 * )
 */
Flight::route('PUT /users/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent', 'client'])();

    $user = Flight::get('user');

    if ($user['role'] === 'client' && $user['user_id'] != $id) {
        Flight::json(['error' => 'You can only update your own profile'], 403);
        return;
    }

    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Delete a user (agent only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="User deleted")
 * )
 */
Flight::route('DELETE /users/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::userService()->delete($id));
});
