<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\QueryException;
use App\Models\ErrorLog;
use App\Helpers\Helpers;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (TokenInvalidException $e, $request) {
            return response()->json(['error'=>'Invalid token'],401);

        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json(['error'=>'Invalid token'],401);

            
        });
        $this->renderable(function(JWTException $exception, $request){
            return response()->json(['error'=>'Unauthorized access'], 401);
        });

        // $this->renderable(function(QueryException $exception, $request){
            
        //     Helpers::createErrorLogs($exception, $request->request_id);
        //     return response()->json(['error'=>'internal server error'], 500);
        // });
        // $this->renderable(function(Exception $exception, $request){
        //     Helpers::createErrorLogs($exception, $request->request_id);
        //     return response()->json(['error'=>'internal server error'], 500);
        // });
        // $this->renderable(function(Error $error, $request){
        
        //     Helpers::createErrorLogs($error, $request->request_id);
        //     return response()->json(['error'=>'internal server error'], 500);
        // });
       
    }
    
    }

    