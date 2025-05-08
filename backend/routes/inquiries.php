<?php

/**
 * @OA\Get(
 *     path="/inquiries",
 *     tags={"Inquiries"},
 *     summary="Get all inquiries",
 *     @OA\Response(
 *         response=200,
 *         description="List of inquiries"
 *     )
 * )
 */
Flight::route('GET /inquiries', function () {
    Flight::json(Flight::inquiryService()->get_all());
});

/**
 * @OA\Get(
 *     path="/inquiries/{id}",
 *     tags={"Inquiries"},
 *     summary="Get inquiry by ID",
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
    Flight::json(Flight::inquiryService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/inquiries/property/{property_id}",
 *     tags={"Inquiries"},
 *     summary="Get inquiries by property ID",
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
    $dao = new InquiryDAO(Flight::get('pdo'));
    Flight::json($dao->getByProperty($property_id));
});

/**
 * @OA\Post(
 *     path="/inquiries",
 *     tags={"Inquiries"},
 *     summary="Create a new inquiry",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=3),
 *             @OA\Property(property="property_id", type="integer", example=7),
 *             @OA\Property(property="message", type="string", example="Is the property available?")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inquiry created"
 *     )
 * )
 */
Flight::route('POST /inquiries', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::inquiryService()->add($data));
});

/**
 * @OA\Delete(
 *     path="/inquiries/{id}",
 *     tags={"Inquiries"},
 *     summary="Delete an inquiry",
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
    Flight::json(Flight::inquiryService()->delete($id));
});
