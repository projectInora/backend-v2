<?php

namespace App\Controller\InternalAPI;

trait InternalAPIErrorCodes
{
    private string $CWE0000X = "Un-defined Exception!";
    private string $CWE0000Y = "Request data validation failed";
    private string $CWE00000 = "Invalid Request Data Format!";
    private string $BEI00001 = "Invalid image file!";
    private string $BEI00002 = "Invalid Request Data Format!";
    public function getErrorMessage(string $errorCode): array
    {
        if(isset($this->{$errorCode})){
            return ['errorCode'=>$errorCode, 'message'=>$this->{$errorCode}];
        }

        return ['errorCode'=>'DME101', 'message'=>'Un-defined error code'];
    }
}