<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const DEFAULT_ELEMENTS_PER_PAGE = 10;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result = [], $message)
    {
        $response = array();
        $response['error'] = false;
        $response['message'] = $message;
        $response['data'] = (empty($result)) ? (object)[] : $result;

        return response()->json((array)$response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'error' => true,
            'message' => $error,
        ];
        $response['data'] = (object)$errorMessages;
        return response()->json($response, $code);
    }
}
