<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Get(
 *     path="/properties",
 *     tags={"Properties"},
 *     summary="Get all properties",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all properties"
 *     )
 * )
 */
Flight::route('GET /properties', function () {
    AuthMiddleware::handle();
    Flight::json(Flight::propertyService()->get_all());
});

/**
 * @OA\Get(
 *     path="/properties/{id}",
 *     tags={"Properties"},
 *     summary="Get a property by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Property ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Property details"
 *     )
 * )
 */
Flight::route('GET /properties/@id', function ($id) {
    AuthMiddleware::handle();
    Flight::json(Flight::propertyService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/properties",
 *     tags={"Properties"},
 *     summary="Create a new property",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "city", "type", "agent_id"},
 *             @OA\Property(property="title", type="string", example="Modern Apartment"),
 *             @OA\Property(property="city", type="string", example="Sarajevo"),
 *             @OA\Property(property="type", type="string", example="Apartment"),
 *             @OA\Property(property="details", type="string", example="Spacious and well-lit apartment in the city center"),
 *             @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
 *             @OA\Property(property="price", type="number", format="float", example=950.00),
 *             @OA\Property(property="agent_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Property created"
 *     )
 * )
 */
Flight::route('POST /properties', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::propertyService()->add($data));
});

/**
 * @OA\Delete(
 *     path="/properties/{id}",
 *     tags={"Properties"},
 *     summary="Delete a property",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Property deleted"
 *     )
 * )
 */
Flight::route('DELETE /properties/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::propertyService()->delete($id));
});
