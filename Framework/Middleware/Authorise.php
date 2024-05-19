<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorise{

    //检查用户是否认证
    public function isAuthenticated(){
        //检查会话
        return Session::has('user');
    }

    //处理用户请求
    public function handle($role){
        //如果用户是访客且认证则去首页
        if($role === 'guest' && $this->isAuthenticated()){
            return redirect('/');
        }
        //如果用户是auth（需认证）且未认证则去登录
        elseif($role == 'auth' && !$this->isAuthenticated()){
            return redirect('/auth/login');
        }
    }
}