<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Middleware\Authorise;
use Framework\Authorisation;


class ListingController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    //展示所有岗位
    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listing ORDER BY created_at DESC')->fetchAll();

        loadView('listings/index', ['listings' => $listings]);
    }


    //创建实习
    public function create()
    {
        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';

        $params = ['id' => $id];

        $listing = $this->db->query('SELECT * FROM listing WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound(
                '该岗位不存在!'
            );
            return;
        }

        loadView('listings/show', ['listing' => $listing]);
    }

    //在数据库在存储数据

    public function store()
    {
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'province', 'phone', 'email', 'requirements', 'benefits'];

        //从 $_POST中提取允许的字段
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        //设置用户ID
        $newListingData['user_id'] = Session::get('user')['id'];

        //清洗数据
        $newListingData = array_map('sanitize', $newListingData);

        //定义必须的字段
        $requiredFields = ['title', 'description', 'email', 'city', 'province'];

        //检查必须的字段
        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . '为必需项';
            }
        }

        //错误处理
        if (!empty($errors)) {
            //如果有错则重载列表视图和显示错误
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            //初始化一个数组来收集所有学校名称，为构建SQL查询做准备
            $fields = [];

            //遍历$newListingData数组，收集字段名称

            foreach ($newListingData as $field => $value) {
                //末尾追加元素
                $fields[] = $field;
            }

            //使用implode转换字符串
            $fields = implode(', ', $fields);

            //初始化一个数组收集占位符
            $values = [];

            //遍历$newListingData 为每个字段生成一个占位符，处理空字符串为null
            foreach ($newListingData as $field => $value) {
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }

            $values = implode(', ', $values);

            //构建SQL插入语句
            $query = "INSERT INTO listing ({$fields}) VALUES ({$values})";

            //执行SQL操作
            $this->db->query($query, $newListingData);

            Session::setFlashMessage('success_message','已成功创建职位！');

            //重定向列表
            redirect('/listings');
        }
    }

    //删除列表项

    public function destroy($params)
    {
        //获取ID
        $id = $params['id'];

        //准备参数
        $params = [
            'id' => $id
        ];

        //查询数据库确认存在

        $listing = $this->db->query('SELECT * FROM listing WHERE id = :id', $params)->fetch();

        //如果为空则列表项不存在
        if (!$listing) {
            ErrorController::notFound('职位不存在！');
            return;
        }

        if(!Authorisation::isOwner($listing->user_id)){
            inspect($_SESSION);
            Session::setFlashMessage('error_message','你没有权限删除此职位！');
            return redirect('/listings/' . $listing->id);

        }

        //执行删除操作

        $this->db->query('DELETE FROM listing WHERE id = :id', $params);

        //设置提示信息

        Session::setFlashMessage('error_message','删除职位成功！');


        //重定向列表页
        redirect('/listings');
    }

    //显示列表项编辑表单

    public function edit($params)
    {
        //尝试从参数中获取ID，如果没有提供，则默认为空字符串
        $id = $params['id'] ?? '';
        // 准备用于数据库查询的参数
        $params = [
            'id' => $id
        ];
        //查询数据库，获取指定ID的列表项数据
        $listing = $this->db->query('SELECT * FROM listing WHERE id = :id', $params)->fetch();
        // 检查查询结果，确保列表项存在
        if (!$listing) {
            //如果未找到列表项，调用错误控制器并返回
            ErrorController::notFound('职位不存在!');
            return;
        }

        //授权
        if (!Authorisation::isOwner($listing->user_id)){
            Session::setFlashMessage('error_message','你没有权限修改此职位！');
            return redirect('/listings/' . $listing->id);
        }

        //如果列表项存在，加载编辑视图并传递列表项数据
        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    //更新列表项内容

    public function update($params)
    {
        //从参数中尝试获取列表项ID，如果没有提供，则默认为空字符串
        $id = $params['id'] ?? '';
        // 准备用于数据库查询的参数
        $params = [
            'id' => $id
        ];
        //查询数据库以确认列表项是否存在
        $listing = $this->db->query('SELECT * FROM listing WHERE id = :id', $params)->fetch();
        //如果列表项不存在
        if (!$listing) {
            // 调用错误控制器并结束方法执行
            ErrorController::notFound('职位不存在!');
            return;
        }

        //授权
        if (!Authorisation::isOwner($listing->user_id)){
            Session::setFlashMessage('error_message','你没有权限修改此职位！');
            return redirect('/listings/' . $listing->id);
        }

        // 定义可以从表单接收的字段列表
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'province', 'phone', 'email', 'requirements', 'benefits'];
        // 过滤并仅保留允许的字段
        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));
        // 对过滤后的数据进行清洗
        $updateValues = array_map('sanitize', $updateValues);
        // 定义必须填写的字段列表
        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'province'];
        // 初始化错误收集数组
        $errors = [];
        //检查必填字段是否已填写且符合要求
        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . '为必需项!';
            }
        }

        // 如果存在错误
        if (!empty($errors)) {
            //重新加载编辑视图并传递错误信息与当前列表数据
            loadView('listings/edit', ['listing' => $listing, 'errors' => $errors]);
            exit;
        } else {
            // 构建 SQL 更新语句中的字段赋值部分
            $updateFields = [];
            foreach (array_keys($updateValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
                //将字段赋值部分合成字符串
            }
            $updateFields = implode(',', $updateFields);
            // 构建完整的 SQL 更新语句
            $updateQuery = "UPDATE listing SET $updateFields WHERE id = :id";
            //在更新数据中包括 ID
            $updateValues['id'] = $id;
            //执行 SQL 更新操作
            $this->db->query($updateQuery, $updateValues);
            //设置成功消息
            Session::setFlashMessage('success_message','职位信息已更新!');
            //重定向到列表项详情页面
            redirect('/listings/' . $id);
        }
    }

    //根据关键词和地点搜索列表
    public function search(){
        //GET中获取关键词和地点,没有则为空字符串
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';

        //构建SQL查询
        $query = "SELECT * FROM listing WHERE 
        (title LIKE :keywords OR description LIKE :keywords OR 
        tags LIKE :keywords OR company LIKE :keywords) AND 
        (city LIKE :location OR province LIKE :location)";

        //准备查询参数
        $params = [
            'keywords' => "%{$keywords}%",
            'location' => "%{$location}%"
        ];

        //执行查询并获取所有匹配的记录
        $listings = $this->db->query($query, $params)->fetchAll();

        //加载列表视图,传递查询到的数据及条件
        loadView('/listings/index',[
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location
        ]);

    }
}
