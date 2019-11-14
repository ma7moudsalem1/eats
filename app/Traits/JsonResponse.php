<?php

namespace App\Traits;

trait JsonResponse {

    public function successResponse($responseName, $response, $message = 'your request sent successfull', $status = 200)
    {
        $response = empty($response) || $response == [] ? null : $response;
        $return = [
            'result' => [
                'success' => true,
                'message' => $message,
                'status'  => $status
            ],
            $responseName => $response
        ];
        return response($return, $status);
    }

    public function failResponse($responseName, $response, $message, $errors = [], $status = 200)
    {
        $response = empty($response) || $response == [] ? null : $response;
        $return = [
            'result' => [
                'success' => false,
                'message' => $message,
                'status'  => $status,
                'errors'  => $errors
            ],
            
            $responseName => $response
        ];
        return response($return, 200);
    }
}