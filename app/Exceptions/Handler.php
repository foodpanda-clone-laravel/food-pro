<?php

namespace App\Exceptions;

use Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Database\QueryException;
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
        $this->renderable(function (Exception $exception, $request) {

            Helpers::createErrorLogs($exception, $request->request_id);
            dd($exception);

        });
        $this->renderable(function (QueryException $exception, $request) {
           Helpers::createErrorLogs($exception, $request->request_id);
            dd($exception);

        });
        $this->renderable(function (Error $error, $request) {

            Helpers::createErrorLogs($error, $request->request_id);
            dd($error);

        });

    }
}


