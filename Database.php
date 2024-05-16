<?php

class Database
{
    public $conn;

    //构造器
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};
        port={$config['port']};
        dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password']);
            // echo "连接成功！";
        } catch (PDOException $e) {
            throw new Exception("数据库连接失败:{$e->getMessage()}");
        }
    }

    //执行数据库请求
    public function query($query){
        try{
            $sth = $this->conn->prepare($query);
        $sth->execute();
        return $sth;

        }catch(PDOException $e){
            throw new Exception("数据库请求执行失败:{$e->getMessage()}");
        }
    }
}
