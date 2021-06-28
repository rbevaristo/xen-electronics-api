<?php


namespace App\Http\Helpers;


use Illuminate\Http\JsonResponse;

class ResponseUtil
{
    /**
     * @param $result
     * @param $status
     * @return JsonResponse
     */
    public static function errorJsonResponse($result, $status)
    {
        return response()->json([
            'success' => false,
            'result' => $result
        ], $status);
    }

    /**
     * @param $result
     * @param $status
     * @return JsonResponse
     */
    public static function successJsonResponse($result, $status = 200)
    {
        return response()->json([
            'success' => true,
            'result' => $result
        ], $status);
    }
}
