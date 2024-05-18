<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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

}