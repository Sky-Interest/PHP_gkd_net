<?php

namespace App\Controllers;

class ErrorController{
    //404notfound
    public static function notFound($message='资源不存在!') {
        http_response_code(404);

        loadView('error',[
            'status' => '404',
            'message'=> $message
        ]);
    }

    //403 无权限错误

    public static function unauthorized($message= '您无访问该资源的权限!') {
        http_response_code(403);

        loadView('error',[
            'status' => '403',
            'message'=> $message
        ]);
    }

}