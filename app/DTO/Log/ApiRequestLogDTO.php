<?php

namespace App\DTO\Log;

use App\DTO\BaseDTO;

class ApiRequestLogDTO extends BaseDTO
{
    public function __construct($request, $response=null)
    {
        $this->method = $request->method();
        $this->controller_action =optional($request->route())->getActionName();
        $this->middleware =  implode(',', array_keys($request->route()->middleware() ?? []));
        $this->path=$request->path();
        $this->ip_address = $request->ip();
        $this->request_params = json_encode(empty($request->query())? null : $request->query());
        $this->request_payload =json_encode(empty($request->all()) ? null : $request->all());
        $this->request_headers = json_encode($request->headers->all());
        if($response){
            $this->status = $response->status();
            $duration = microtime(true)-$request->start_time;
            $this->duration = number_format($duration, 4).'s';
            $this->response_headers = json_encode($response->headers->all());
            $this->response_json = json_encode($response->getContent());
            $this->memory_usage = number_format(memory_get_usage(true)/1024/1024,2).' MB';
        }


    }
}
