<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseAPIController extends Controller
{
    public function success($data = [], string $message = "OK", $status = 200)
    {
        return response()->json([
            "data" => $data,
            "meta" => [
                "message" => $message
            ]
        ], $status);
    }
}
