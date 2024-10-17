<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{

    // Response For Login
    public function loginResponse(array $data, $token, string $message = 'Login successful', int $statusCode = 201): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data['user'],
            'access_token' => $token,
            'expires_in' => $data['expires_in'],
            'token_type' => $data['token_type'],

        ], $statusCode);
    }

    // Response with data
    public function successResponse($data = [], string $message = 'Operation successful', int $statusCode = 200): JsonResponse
    {
        // dd($data);
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // Response without data
    public function successMessage(string $message = 'Operation successful', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ], $statusCode);
    }

    // Response with pagination
    public function paginatedResponse($data, string $message = 'Data retrieved successfully', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'meta' => $this->paginationInfo($data)
        ], $statusCode);
    }

    // Response with error
    public function errorResponse(string $message = 'Operation failed', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    // Response with error and data
    public function errorWithDataResponse($data = [], string $message = 'Operation failed', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // Response with not found
    public function notFoundResponse(string $message = 'Resource not found', int $statusCode = 404): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    // Response with unauthorized
    public function unauthorizedResponse(string $message = 'Unauthorized', int $statusCode = 401): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    // Response with internal error
    public function internalErrorResponse(string $message = 'Internal server error', int $statusCode = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
    public function paginationInfo($data)
    {
        return [
            'total_items' => $data->total(),
            'has_more' => $data->hasMorePages(),
            'total_pages' => $data->lastPage(),
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            // 'links' => $data->links(),
            // 'data' => $data->items(),
        ];
    }
}
