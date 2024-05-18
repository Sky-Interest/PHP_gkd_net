<?php

namespace Framework;

class Session{

    //开启会话
    public static function start(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    //设置对话键值对
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    //通过键获取会话值
    public static function get($key, $default = null){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    //检查会话键是否存在
    public static function has($key){
        return isset($_SESSION[$key]);
    }

    //清除指定会话键
    public static function clear($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }

    //清除所有对话数据
    public static function clearAll(){
        session_unset();//移除所有会话变量
        session_destroy();//销毁会话
    }
}