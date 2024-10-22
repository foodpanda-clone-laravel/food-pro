<?php

namespace App\Http\Middleware;

use App\DTO\Log\ApiRequestLogDTO;
use App\Models\Logs\ApiRequestLog;
use Closure;
use Illuminate\Http\Request;

class APIRequestLogsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        $apiRequestLogDto = new ApiRequestLogDTO($request);
        $apiRequestLog = ApiRequestLog::create($apiRequestLogDto->toArray());
        $request->request_id = $apiRequestLog['id'];

        $request->start_time = $startTime;
        return $next($request);
    }
    public function terminate(Request $request, $response): void
    {

        $id = $request->request_id;
        $apiRequestLog = ApiRequestLog::where('id',$id)->first();
        $apiRequestLogDto = new ApiRequestLogDTO($request,$response);
        $apiRequestLog->update($apiRequestLogDto->toArray());
    }
}
