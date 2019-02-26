<?php
/**
 * Created by PhpStorm.
 * User: Nymeria
 * Date: 2018/9/22 0022
 * Time: 上午 11:25
 */

require_once 'function.php';
if(empty($_GET['id'])){
    exit('缺少必要参数');
}
$id=$_GET['id'];

$affected_rows=execute("delete from users where id={$id}");
header('Location: 数据库操作.php');
