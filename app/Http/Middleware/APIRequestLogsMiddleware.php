<?php

namespace App\Http\Middleware;

use App\Models\Logs\ApiRequestLog;
use Closure;
use Illuminate\Http\Request;

class APIRequestLogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        dd($request);
        $startTime = microtime(true);
        $controllerAction = optional($request->route())->getActionName();

        $middleware = implode(',', array_keys($request->route()->middleware() ?? []));

        $requestParams = empty($request->query())? null : $request->query();
        $requestPayload = empty($request->all()) ? null : $request->all();
        $apiRequestLog = ApiRequestLog::create([
            'method'=>$request->method(),
            'controller_action'=>$controllerAction,
            'middleware'=>$middleware,
            'path'=>$request->path(),
            'ip_address'=>$request->ip(),
            'request_params'=>json_encode($requestParams),
            'request_payload'=>json_encode($requestPayload),
            'request_headers'=>json_encode($request->headers->all()),
        ]);
        dd($apiRequestLog);
        $request->request_id = $apiRequestLog->id;
        $request->start_time = $startTime;
        return $next($request);
    }
    public function terminate(Request $request, $response): void
    {

        $duration = microtime(true)-$request->start_time;

        $status = $response->status();
        $responseJson = $response->getContent();
        $memoryUsage = number_format(memory_get_usage()  / 1024 / 1024, 2)." MB";
        $id = $request->request_id;
        $apiRequestLog = ApiRequestLog::where('id',$id)->first();
        $apiRequestLog->update([
            'status'=>$status,
            'duration'=>number_format($duration, 4) . ' s',
            'response_headers'=>json_encode($response->headers->all()),
            'response_json'=>$responseJson,
            'memory_usage'=>$memoryUsage
        ]);


    }
}
