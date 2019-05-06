<?php
namespace Api\API;

class ApiError{
    public static function errorMessage($message, $code){
        return [
            'data' => [
                'msg' => $message,
                'codigo interno' => $code
            ]
            ];
    }
}