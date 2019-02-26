<?php
/**
 * Created by PhpStorm.
 * User: Nymeria
 * Date: 2018/9/22 0022
 * Time: 上午 10:53
 */
header("content-type:text/html; charset=utf8");
echo '<pre>';
//连接数据库
$connect=mysqli_connect('127.0.0.1','root','197311','crud');
// mysqli_query($connect,"set names 'utf8'");
if(!$connect){
    $GLOBALS['message']='连接数据库失败';
    exit();
}
//查找数据
$query=mysqli_query($connect,'select * from users;');
if(!$query){
    $GLOBALS['message']='查询失败';
    exit();
}
//准备空数组保存数据
$data=array();

while($row=mysqli_fetch_assoc($query)){
    $data[]=$row;
}

//释放查询结果集
mysqli_free_result($query);

//释放连接
mysqli_close($connect);

echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件域</title>
    <style>
        .avatar{
            height: 160px;
            width: 120px;
        }
    </style>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>名字</th>
        <th>性别</th>
        <th>生日</th>
        <th>头像</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['gender']=='1'?'男':'女'; ?></td>
            <td><?php echo $item['birthday']; ?></td>
            <td><img src="<?php echo $item['avatar']; ?>" class="avatar"></img></td>
            <td>
                <a class="btn btn-primary btn-sm" href="add.php">添加</a>
                <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $item['id']; ?>">修改</a>
                <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $item['id']; ?>">删除</a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
</body>
</html>



