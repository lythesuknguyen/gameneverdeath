<?php

namespace Packages\System;

class SystemAPI {
    
    function HTTPStatusCodeMessage($code){
        $http_codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        if(isset($http_codes[$code])){
            return $http_codes[$code];
        } else {
            return "Unknow Message";
        }
    }

    function APIResponseBody($msg, $return_code){
        $body = array(
            "code"=>$return_code,
            "msg"=>$msg            
        );
        return json_encode($body);
    }

    function APIResponse($code, $body){
        $statusCodeMessage = $this->HTTPStatusCodeMessage($code);
        $status_header = "HTTP/1.1 $code $statusCodeMessage";
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header("Content-type: $content_type");
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Headers: Accept');       
        if($body == null){
            //echo json_encode(array("message"=>$statusCodeMessage));
            echo $this->APIResponseBody($statusCodeMessage, $code);
        } else {
            return $body;
        }
    }

}

