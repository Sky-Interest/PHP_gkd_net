<?php 

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController{

    protected $db;

    public function __construct(){
        $config = require basePath('config/db.php');
        $this->db = new Database($config);

    }

    public function index(){
        $listings = $this->db->query('SELECT * FROM listing')->fetchAll();

        loadView('listings/index',['listings' => $listings]);

    }

    public function create(){
        loadView('listings/create');
    }

    public function show($params){
        $id = $params['id'] ?? '';

        $params = ['id' => $id];

        $listing = $this->db->query('SELECT * FROM listing WHERE id = :id',$params)->fetch();

        if(!$listing) {
            ErrorController::notFound(
                '该岗位不存在!'
            );
            return;
        }

        loadView('listings/show',['listing' => $listing]);
    }

    //在数据库在存储数据

    public function store(){
        $allowedFields = ['title','description','salary','tags','company','address','city','pvovince','phone','email','requirements','benefits'];

        //从 $_POST中提取允许的字段
        $newListingData = array_intersect_key($_POST,array_flip($allowedFields));

        //设置用户ID
        $newListingData['user_id'] = 1;

        //清洗数据
        $newListingData = array_map('sanitize', $newListingData);

        //定义必须的字段
        $requiredFields = ['title','description','email','city','province'];

        //检查必须的字段
        $errors = [];
        foreach($requiredFields as $field){
            if(empty($newListingData[$field])|| !Validation::string($newListingData[$field])){
                $errors[$field] = ucfirst($field) . '为必需项';
            }
        }

        //错误处理
        if(!empty($errors)){
            //如果有错则重载列表视图和显示错误
            loadView('listings/create',[
                'errors'=> $errors,
                'listing'=> $newListingData
            ]);
        }else{
            //初始化一个数组来收集所有学校名称，为构建SQL查询做准备
            $fields = [];

            //遍历$newListingData数组，收集字段名称

            foreach($newListingData as $field => $value){
                //末尾追加元素
                $fields[] = $field;
            }

            //使用implode转换字符串
            $fields = implode(', ', $fields);

            //初始化一个数组收集占位符
            $values = [];

            //遍历$newListingData 为每个字段生成一个占位符，处理空字符串为null
            foreach($newListingData as $field => $value){
                if($value === ''){
                    $newListingData[$field] = null;

                }
                $values[] = ':' . $field;
            }

            $fields = implode(', ', $values);

            //构建SQL插入语句
            $query = "INSERT INTO listing ({$fields}) VALUES ({$values})";

            //执行SQL操作
            $this->db->query($query,$newListingData);

            //重定向列表
            redirect('/listings');
        }

    }
}