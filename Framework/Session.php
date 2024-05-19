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

    //设置闪存信息
    public static function setFlashMessage($key,$message){
        //调用set在键名前加上前缀区分
        self::set('flash_' . $key, $message);
    }

    //获取闪存信息并其后立即删除
    public static function getFlashMessage($key, $default = null){
        //从会话中获取信息，没有则返回默认值
        $message = self::get('flash_' . $key, $default);

        //删除会话信息
        self::clear('flash_' . $key);
        return $message;
    }
}