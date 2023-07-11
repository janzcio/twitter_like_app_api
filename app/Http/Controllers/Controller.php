<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Generate success Response
     * @param  array $data [description]
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateSuccess($data = [], $mergeArray = true)
    {
        $arr = [
            'status' => 'Success',
            'description' => 'Ok'
        ];

        if ($mergeArray) {
            return response()->json(array_merge($arr, ['data' => $data]), Response::HTTP_OK);
        }

        return response()->json($arr, Response::HTTP_OK);
    }

    /**
     * Generate success created Response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateSuccessCreated($data = [], $mergeArray = true)
    {
        $arr = [
            'status' => 'Success',
            'description' => 'Created'
        ];

        if ($mergeArray) {
            return response()->json(array_merge($arr, ['data' => $data]), Response::HTTP_CREATED);
        }

        return response()->json($arr, Response::HTTP_CREATED);
    }

    /**
     * Generate not found Response
     * @return [type] [description]
     */
    protected function generateNotFoundResponse()
    {
        return response()->json([
            'status' => 'Error',
            'description' => 'Not found',
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Generate Unauthorized Response
     * @return [type] [description]
     */
    protected function generateUnauthorizedResponse()
    {
        return response()->json([
            'status' => 'Error',
            'description' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Generate Conflict Response
     * @return [type] [description]
     */
    protected function generateConflictResponse($data = [], $mergeArray = true)
    {
        $arr = [
            'status' => 'Success',
            'description' => 'Created'
        ];

        if ($mergeArray) {
            return response()->json(array_merge($arr, ['data' => $data]), Response::HTTP_CONFLICT);
        }

        return response()->json($arr, Response::HTTP_CONFLICT);
    }
}
