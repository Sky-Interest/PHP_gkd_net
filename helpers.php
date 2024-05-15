<?php
    function basePath($path =''){
        return __DIR__ .'/' .$path;
    }

    function loadPartial($name){
//         - **参数**：**`$name`**，代表要加载的部分视图（partial）的名称。
// - **功能**：通过拼接**`basePath`**函数返回的路径和传入的视图文件名来构建完整的文件路径，然后使用**`require`**语句加载指定的视图文件。
        $partialPath = basePath("views/partials/{$name}.php");

        if (file_exists($partialPath)){
            require $partialPath;
        }else{
            echo "{$name}部分视图不存在";
        }
    }

    function loadView($name){
        $viewPath = basePath("views/{$name}.view.php");
        if(file_exists($viewPath)){
            require $viewPath;
        }else{
            echo"{$viewPath}视图不存在!";
        }
    }
?>