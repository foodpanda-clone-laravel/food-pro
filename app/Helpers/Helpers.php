<?php
namespace App\Helpers;
use App\DTO\Log\ErrorLogDTO;
use App\Models\Logs\ErrorLog;
use Illuminate\Http\Response;

class Helpers{

    public static function sendSuccessResponse(int $status, string $message, $data=[], $headers=null)
    {
        $response = [
            'status'=>$status,
            'message'=>$message,
        ];
        if($status >=200 && $status < 399){
            $response['data']=$data;
        }else{
            $response['errors']=$data;
        }

        if($headers){
            return response()->json($response, $status)->withHeaders($headers);
        }
        else{
            return response()->json($response, $status);

        }
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param array $data
     *
     * in case of failure response send it to error logs
     */
    public static function sendFailureResponse(int $headerCode, string $functionName, $e)
    {

        return [
          'header_code' => $headerCode,
          'message'=> Response::$statusTexts[$headerCode],
          'body' => $e->getMessage(),
        ];
    }
    public static function createErrorLogs($exception, $functionName)
    {
        $errorLog = new ErrorLogDTO($exception, $functionName);
        ErrorLog::create($errorLog->toArray());
    }
}
