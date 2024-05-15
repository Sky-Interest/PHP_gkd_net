<?php
    function basePath($path =''){
        return __DIR__ .'/' .$path;
    }

    function loadPartial($name){
//         - **参数**：**`$name`**，代表要加载的部分视图（partial）的名称。
// - **功能**：通过拼接**`basePath`**函数返回的路径和传入的视图文件名来构建完整的文件路径，然后使用**`require`**语句加载指定的视图文件。
        require basePath("views/partials/{$name}.php");
    }
?>