<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

/**
 * @OA\Get(
 *     path="/inquiries",
 *     tags={"Inquiries"},
 *     summary="Get all inquiries (agent only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of inquiries"
 *     )
 * )
 */
Flight::route('GET /inquiries', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

     try {
        $data = Flight::inquiryService()->get_all();
        Flight::json($data);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/inquiries/property/{property_id}",
 *     tags={"Inquiries"},
 *     summary="Get inquiries by property ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="property_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiries for the property"
 *     )
 * )
 */
Flight::route('GET /inquiries/property/@property_id', function ($property_id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::inquiryService()->getByProperty($property_id));
});

/**
 * @OA\Get(
 *     path="/inquiries/{id}",
 *     tags={"Inquiries"},
 *     summary="Get inquiry by ID (agent only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiry details"
 *     )
 * )
 */
Flight::route('GET /inquiries/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::inquiryService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/inquiries",
 *     tags={"Inquiries"},
 *     summary="Submit a new property inquiry (client only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"property_id", "user_id", "question"},
 *             @OA\Property(property="property_id", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=5),
 *             @OA\Property(property="question", type="string", example="Is the apartment pet-friendly?")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiry submitted"
 *     )
 * )
 */
Flight::route('POST /inquiries', function () {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['client'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::inquiryService()->add($data));
});

/**
 * @OA\Put(
 *     path="/inquiries/{id}",
 *     tags={"Inquiries"},
 *     summary="Agent responds to an inquiry",
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
 *             @OA\Property(property="answer", type="string", example="Yes, it is pet-friendly.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiry answered"
 *     )
 * )
 */
Flight::route('PUT /inquiries/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    $data = Flight::request()->data->getData();
    Flight::json(Flight::inquiryService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/inquiries/{id}",
 *     tags={"Inquiries"},
 *     summary="Delete an inquiry (agent only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiry deleted"
 *     )
 * )
 */
Flight::route('DELETE /inquiries/@id', function ($id) {
    AuthMiddleware::handle();
    RoleMiddleware::allow(['agent'])();

    Flight::json(Flight::inquiryService()->delete($id));
});
