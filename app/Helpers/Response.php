<?php

namespace App\Helpers;

use App\Helpers\customCode;

Trait Response {

    public function error($msg, $httpCode) {
        return response()->json([
            'status' => false,
            'http_code' =>$httpCode,
            'message' => $msg
        ], $httpCode);
    }

    public static function success($msg, $httpCode, $data = []) {
        return response()->json([
            'status' => true,
            'http_code' => $httpCode,
            'message' => $msg,
            'data' => $data
        ], $httpCode);
    }



}
