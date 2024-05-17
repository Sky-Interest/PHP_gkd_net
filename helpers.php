<?php
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

function loadPartial($name)
{
    $partialPath = basePath("APP/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "{$name}部分视图不存在";
    }
}

//加载视图
function loadView($name,$data = [])
{
    $viewPath = basePath("APP/views/{$name}.view.php");

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
