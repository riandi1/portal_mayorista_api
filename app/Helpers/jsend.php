<?php

if (!function_exists("jsend_error")) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_error($message, $status = 500, $code = "", $data = "", $extraHeaders = [])
    {
        $response = [
            "status" => "error",
            "message" => $message
        ];
        if ($code) $response['code'] = $code;
        if ($data) $response['data'] = $data;
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response()->json($response, $status, $headers);
    }
}

if (!function_exists("jsend_fail")) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param string $message
     * @param array $extraHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_fail($data, $status = 400, $message = "", $extraHeaders = [])
    {
        $response = [
            "status" => "fail",
            "data" => $data
        ];
        if ($message) $response["message"] = $message;
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response()->json($response, $status, $headers);
    }
}

if (!function_exists("jsend_success")) {
    /**
     * @param array | App\Models\Model $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_success($data = [], $status = 200, $message = "", $extraHeaders = [], $pagination = null)
    {
        $data = ($data instanceof Illuminate\Database\Eloquent\Model) ? $data->toArray() : $data;
        $response = [
            "status" => "success",
            "data" => $data
        ];
        if(!is_null($pagination))
            $response['pagination'] = $pagination;
        if ($message) $response["message"] = $message;
        $headers = array_merge(["Content-Type" => "application/json"], $extraHeaders);
        $response = response()->json($response, $status, $headers);
        return $response->withHeaders([
            'Content-Length' => strlen($response->content())
        ]);
    }
}
