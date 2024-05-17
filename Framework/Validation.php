<?php

namespace Framework;

class Validation
{
    //验证字符串是否符合长度

    public static function string($value, $min = 1, $max = INF)
    {
        if (is_string($value)) {
            $value = trim($value);
            $length = strlen($value);
            return $length >= $min && $length <= $max;
        }
        return false;
    }

    //验证电子邮箱地址

    public static function email($value){
        $value = trim($value);
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    //比较两个值是否相等

    public static function match($value1,$value2){
        $value1 = trim($value1);
        $value2 = trim($value2);
        return $value1 == $value2;
    }
    
}
