<?php
//操作结果判断
function operation_result($result){
    switch ($result){
        case 1:
            return'<span class="alert alert-success">添加成功</span>';
        break;
        case -1:
            return'<span class="alert alert-danger">添加失败</span>';
        break;
        case 2:
            return'<span class="alert alert-success">删除成功</span>';
        break;
        case -2:
            return'<span class="alert alert-danger">删除失败</span>';
        break;
        case 3:
            return'<span class="alert alert-success">修改成功</span>';
        break;
        case -3:
            return'<span class="alert alert-danger">修改失败</span>';
        break;
        
    }
}