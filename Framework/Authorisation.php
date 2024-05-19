<?php 

namespace Framework;

use Framework\Session;

class Authorisation{

    //检查当前登录的用户是否有指定资源的所有权  
    public static function isOwner($resourceId){
        //获取会话中信息
        $sessionUser = Session::get('user');

        //检查会话中是否存在用户信息并其ID是否已设置
        if($sessionUser !== null && isset($sessionUser['id'])){
            //将ID转换为整数
            $sessionUserId = (int)$sessionUser['id'];
            //比较ID
            return $sessionUserId === $resourceId; 
        }

        //如果没有用户信息或ID未设置 返回false
        return false;
    }

}