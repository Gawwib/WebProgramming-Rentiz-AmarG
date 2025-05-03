<?php

/**
 * @OA\Get(
 *     path="/properties",
 *     tags={"Properties"},
 *     summary="Get all properties",
 *     @OA\Response(
 *         response=200,
 *         description="List of all properties"
 *     )
 * )
 */
Flight::route('GET /properties', function () {
    Flight::json(Flight::propertyService()->get_all());
});

/**
 * @OA\Get(
 *     path="/properties/{id}",
 *     tags={"Properties"},
 *     summary="Get a property by ID",
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
    Flight::json(Flight::propertyService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/properties",
 *     tags={"Properties"},
 *     summary="Create a new property",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Modern Apartment"),
 *             @OA\Property(property="description", type="string", example="Spacious and well-lit apartment"),
 *             @OA\Property(property="location", type="string", example="Sarajevo"),
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
    $data = Flight::request()->data->getData();
    Flight::json(Flight::propertyService()->add($data));
});

/**
 * @OA\Delete(
 *     path="/properties/{id}",
 *     tags={"Properties"},
 *     summary="Delete a property",
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
    Flight::json(Flight::propertyService()->delete($id));
});
