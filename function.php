<?php
/**
 * Created by PhpStorm.
 * User: Nymeria
 * Date: 2018/9/22 0022
 * Time: 下午 03:30
 */
require_once 'config.php';

/*
 * 通过一个数据库查询获取数据
 * 返回的是索引数组，索引数组包含关联数组
 */
//获取多条数据
function fetch_all($sql){
    $connect=mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
    if(!$connect){
        exit('连接数据库失败！');
    }
	// mysqli_query($connect,'set names utf8');
    $query=mysqli_query($connect,$sql);
    $result=array();
    if(!$query){
//        查询失败
        return false;
    }
    while($row=mysqli_fetch_assoc($query)){
        $result[]=$row;
    }

    mysqli_free_result($query);
    mysqli_close($connect);
    return $result;


}

//获取单条数据
function fetch_one($sql){
    $res=fetch_all($sql);
    return isset($res[0]) ? $res[0]: null;
}

/*
 * 执行一个增删改语句
 */
//添加数据
function execute($sql){
    $connect=mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
    if(!$connect){
        exit('连接数据库失败！');
    }
	// mysqli_query($connect,'set names utf8');
    $query=mysqli_query($connect,$sql);

    if(!$query){
//        查询失败
        return false;
    }
//    对于增加 删除 修改数据库的操作，返回的是受影响的函数
    $affected=mysqli_affected_rows($connect);
    return $affected;
}