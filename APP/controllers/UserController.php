<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController{

    protected $db;

    public function __construct(){
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    //显示登录页面

    public function login(){
        loadView('users/login');
    }

    //显示注册页面
    public function create(){
        loadView('users/create');
    }

    //将用户数据储存到数据库中

    public function store(){
        //从 POST 请求中获取用户数据
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        //初始化一个数组存放错误信息
        $errors = [];

        //验证电子邮件
        if (!Validation::email($email)){
            $errors['email'] = '请输入一个合法的电子邮件！';

        }

        //验证名字是否在2-50字符之间
        if (!Validation::string($name,2,50)){
            $errors['name'] = '姓名在2-50之间！';
            
        }

        //验证密码是否至少有6字符
        if (!Validation::string($password,6,50)){
            $errors['password'] = '密码长度至少为6位';
            
        }

        //验证密码与确认密码是否匹配
        if (!Validation::match($password,$passwordConfirmation)){
            $errors['password_confirmation'] = '两次输入的密码不一致！';
            
        }

        //检查是否存在验证错误
        if(!empty($errors)){
            //如果存在错误则重新加载页面并显示错误信息
            loadView('users/create',[
                'errors' => $errors,
                'user' =>[
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'province' => $province
                ]
            ]);
            //终止执行
            exit();
        }else{
            //检查电子邮件是否存在
            $params = [
                'email' => $email
            ];

            //查询是否有相同的电子邮件在数据库
            $user = $this->db->query('SELECT * FROM users WHERE email = :email',$params)->fetch();

            //若电子邮件被注册
            if($user){
                $errors['email'] ='该邮箱已注册!';
                //重载页面并显示错误
                loadView('users/create',[
                    'errors' =>$errors
                ]);
                //终止执行
                exit();
            }

            //创建用户
            $params = [
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'province' => $province,
                'password' => password_hash($password, PASSWORD_DEFAULT)//使用哈希处理密码
            ];

            //插入新用户
            $this->db->query('INSERT INTO users (name, email, city,province, password) 
            VALUES(:name, :email, :city, :province, :password)', $params);

            //获取新用户ID
            $userId = $this->db->conn->lastInsertId();

            Session::set('user',[
                'id' => $userId,
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'province' => $province
            ]);


            //创建成功后重定向回首页
            redirect('/');
        }
    }       
}