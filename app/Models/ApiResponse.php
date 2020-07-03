<?php


namespace App\Models;


class ApiResponse
{

    public static function success(array $data, string $msg = null)
    {
        return response()->json([
            'data'      => $data,
            'msg'       => $msg,
            'timestamp' => $today = \Illuminate\Support\Carbon::now()
                ->format('Y-m-d h:i:s'),
        ], 200);
    }

    public static function error(string $error)
    {
        return response()->json([
            'error'     => $error,
            'timestamp' => $today = \Illuminate\Support\Carbon::now()
                ->format('Y-m-d h:i:s'),
        ], 400);
    }

    public static function errorValidation(array $data)
    {
        return response()->json([
            'errors'    => $data,
            'timestamp' => $today = \Illuminate\Support\Carbon::now()
                ->format('Y-m-d h:i:s'),
        ], 400);
    }

}