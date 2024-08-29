<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * returns a success as a json response
     * 
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success(mixed $data,string $message="ok",int $statusCode=200):JsonResponse
    {
        return response()->json([
            'data'=>$data,
            'success'=>true,
            'message'=>$message,
        ],$statusCode);
    }

    /**
     * returns an error as a json response
     * 
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error(string $message,int $statusCode=400):JsonResponse
    {
        return response()->json([
            'data'=>null,
            'success'=>false,
            'message'=>$message,
        ],$statusCode);
    }
}
