<?php
namespace App\DTO\Log;
use App\DTO\BaseDTO;
class ErrorLogDTO  extends BaseDTO {
    public function __construct($exception, $functionName){
        $this->function_name=$functionName;
        $this->line_number=$exception->getLine();
        $this->file_name=$exception->getFile();
        $this->code=(int) $exception->getCode();
        $this->exception=$exception->getMessage();
        $this->request_id=request()->request_id;
    }
}
