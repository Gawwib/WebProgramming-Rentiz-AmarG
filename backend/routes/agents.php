<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Get(
 *     path="/agents",
 *     tags={"Agents"},
 *     summary="Get all agents",
 *     @OA\Response(
 *         response=200,
 *         description="List of agents"
 *     )
 * )
 */
Flight::route('GET /agents', function () {
    Flight::json(Flight::agentProfileService()->get_all());
});

/**
 * @OA\Get(
 *     path="/agents/{id}",
 *     tags={"Agents"},
 *     summary="Get agent by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Agent details"
 *     )
 * )
 */
Flight::route('GET /agents/@id', function ($id) {
    Flight::json(Flight::agentProfileService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/agents",
 *     tags={"Agents"},
 *     summary="Create a new agent profile",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"agent_id", "license_number"},
 *             @OA\Property(property="agent_id", type="integer", example=2),
 *             @OA\Property(property="license_number", type="string", example="LIC-9988")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Agent profile created"
 *     )
 * )
 */
Flight::route('POST /agents', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::agentProfileService()->add($data));
});

/**
 * @OA\Put(
 *     path="/agents/{id}",
 *     tags={"Agents"},
 *     summary="Update agent's license number",
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
 *             required={"license_number"},
 *             @OA\Property(property="license_number", type="string", example="LIC-1234-NEW")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Agent updated"
 *     )
 * )
 */
Flight::route('PUT /agents/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::agentProfileService()->update($id, $data['license_number']));
});

/**
 * @OA\Delete(
 *     path="/agents/{id}",
 *     tags={"Agents"},
 *     summary="Delete an agent",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Agent deleted"
 *     )
 * )
 */
Flight::route('DELETE /agents/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::agentProfileService()->delete($id));
});
