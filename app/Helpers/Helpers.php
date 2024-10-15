<?php
namespace App\Helpers;
use App\Models\Logs\ErrorLog;

class Helpers{

    public static function sendSuccessResponse(int $status, string $message, $data=[], $headers=null, $cookies=null)
    {
        if($headers){
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'data'=>$data
            ], $status)->withHeaders($headers)->cookie('example', 'sdkfjls');
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'data'=>$data
        ], $status);
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param array $data
     *
     * in case of failure response send it to error logs
     */
    public static function sendFailureResponse(int $status, string $message, $data=[])
    {
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'data'=>$data
        ]);

    }
    public static function createErrorLogs($exception, $requestId){
        dd($exception);
        ErrorLog::create([
            'function_name'=>$exception->getTrace()[0]['function'],
            'line_number'=>$exception->getLine(),
            'file_name'=>$exception->getFile(),
            'code'=>(int) $exception->getCode(),
            'exception'=>$exception->getMessage(),
            'request_id'=>$requestId,
        ]);
    }
}
