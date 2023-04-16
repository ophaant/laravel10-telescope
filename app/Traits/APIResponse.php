<?php

namespace App\Traits;

use App\Helper\ApiCode;

trait APIResponse
{
    /**
     * Core of response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     * @param   boolean         $isSuccess
     */
    public function coreResponse($apiCode, $data = null, $errors=null, $meta=null, $statusCode, $isSuccess = true)
    {
        $response = $apiCode;

        if($isSuccess) {
            $response['success'] = true;
            if ($data){
                $response['data'] = $data;
            }
            if ($meta){
                $response['meta'] = $meta;
            }
            return response()->json($response, $statusCode);
        } else {
            $response['success'] = false;
            if ($errors){
                $response['errors'] = $errors;
            }
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Send any success response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     */
    public function success($apiCode, $data, $meta, $statusCode = 200)
    {
        return $this->coreResponse($apiCode, $data, $meta, null, $statusCode);
    }

    /**
     * Send any error response
     *
     * @param   string          $message
     * @param   integer         $statusCode
     */
    public function error($apiCode, $errors, $statusCode = 500)
    {
        return $this->coreResponse($apiCode, null,$errors, null, $statusCode, false);
    }
}
