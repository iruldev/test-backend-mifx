<?php

namespace App\Traits;

trait apiJsonReturnTrait
{
    public function returnJson($data, $message = '', $status_code = 200, $status = 'ok')
    {
        return response()->json([
            'status'  => $status,
            'code'    => $status_code,
            'message' => $message,
            'data'  => $data,
        ], $status_code);
    }
}
