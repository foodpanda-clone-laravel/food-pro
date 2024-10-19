<?php
namespace App\DTO\Log;
use App\DTO\BaseDTO;
class ErrorLogDTO  extends BaseDTO {
    public function __construct($exception, $requestId){
        $this->function_name=$exception->getTrace()[0]['function'];
        $this->line_number=$exception->getLine();
        $this->file_name=$exception->getFile();
        $this->code=(int) $exception->getCode();
        $this->exception=$exception->getMessage();
        $this->request_id=$requestId;
    }
}
