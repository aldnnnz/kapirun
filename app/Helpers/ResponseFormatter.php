<?php
namespace App\Helpers;


class ResponseFormatter
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'meta' => [
                'success' => true,
                'message' => $message,
                'code' => $code
            ],
            'data' => $data
        ], $code);
    }
    public static function error($data = null, $message = 'Error', $code = 404)
    {
        return response()->json([
            'meta' => [
                'success' => false,
                'message' => $message,
                'code' => $code
            ],
            'data' => $data
        ], $code);
    }
    // public static function errorValidation($errors, $message = 'Validation Error', $code = 400)
    // {
    //     return response()->json([
    //         'meta' => [
    //             'success' => false,
    //             'message' => $message,
    //             'code' => $code,
    //             'errors' => $errors,
    //         ]
    //     ], $code);
    // }

}