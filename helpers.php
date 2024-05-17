<?php
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

function loadPartial($name)
{
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "{$name}部分视图不存在";
    }
}

//加载视图
function loadView($name,$data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "{$viewPath}视图不存在!";
    }
}
//捕获测试
function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '<pre>';
}
//断点测试
function inspectAndDie($value)
{
    echo '<pre>';
    die(var_dump($value));
    echo '<pre>';
}

//清洗数据

function sanitize($dirty){
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}
