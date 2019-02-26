<?php
/**
 * Created by PhpStorm.
 * User: Nymeria
 * Date: 2018/9/22 0022
 * Time: 下午 06:29
 */
require_once 'config.php';
require_once 'function.php';
if(empty($_GET['id'])){
    exit('缺少必要参数');
}
$id=$_GET['id'];
$rows=fetch_one("select * from users where id={$id} limit 1;");
if(!$rows){
    exit('找不到要编辑的数据');
}
//var_dump($rows);


//===================================================
function edit(){
    global $rows;
    if(empty($_GET['id'])){
        exit('缺少必要参数');
    }
    //接收并校验
//================校验名字=================
    if(empty($_POST['name'])){
        $GLOBALS['message']='请输入名字';
        return;
    }
//================校验性别==================
    if(!isset($_POST['gender'])&& $_POST['gender']!=='-1'){
        $GLOBALS['message']='请选择性别';
        return;
    }
    //================校验生日==================
    if(empty($_POST['birthday'])){
        $GLOBALS['message']='请选择生日';
        return;
    }
    //==============校验头像====================
    if(isset($_FILES['avatar'])&& $_FILES['avatar']['error']===UPLOAD_ERR_OK){
        $avatar=$_FILES['avatar'];
//    var_dump($avatar);
//        上传单张头像
        if($avatar['error']!== UPLOAD_ERR_OK){
            $GLOBALS['message']='头像上传失败';
            return;
        }
        //    对头像大小进行检验
        if($avatar['size']>5*1024*1024){
            $GLOBALS['message']='头像大小不符要求';
            return;
        }
//    对大小格式进行检验
        $allowavatar_type=array('image/jpeg','image/jpg','image/png','image/gif');
        if(!in_array($avatar['type'],$allowavatar_type)){
            $GLOBALS['message']='头像格式不符要求';
            return;
        }
        $initial_avatar=$avatar['tmp_name'];
        $target_avatar='../images/'.uniqid().$avatar['name'];
        $moved_avatar=move_uploaded_file($initial_avatar,$target_avatar);
        if(!$moved_avatar){
            $GLOBALS['message']='头像上传失败';
            return;
        }
        $rows['avatar']=$target_avatar;
		$rows['avatar']=substr($rows['avatar'],2);
    }
    $rows['name']=$_POST['name'];
    $rows['gender']=$_POST['gender'];
    $rows['birthday']=$_POST['birthday'];
//    $connection=mysqli_connect('127.0.0.1','root','197311','test');
//    $query=mysqli_query($connection,"update users set id={$rows['id']},`name`='{$rows['name']}',gender='{$rows['gender']}',birthday='{$rows['birthday']}',avatar='{$rows['avatar']}' where id={$rows['id']}");
//    $affected_rows=mysqli_affected_rows($connection);

    $affected_rows=execute("update users set id={$rows['id']},`name`='{$rows['name']}',gender='{$rows['gender']}',birthday='{$rows['birthday']}',avatar='{$rows['avatar']}' where id={$rows['id']}");
//    echo "update users set id={$rows['id']},`name`='{$rows['name']}',gender='{$rows['gender']}',birthday='{$rows['birthday']}',avatar='{$rows['avatar']}' where id='{$rows['id']}'";
    var_dump($affected_rows);
    var_dump($rows);
   header('Location: 数据库操作.php');
}
if($_SERVER['REQUEST_METHOD']==='POST') {
    edit();
}
//var_dump($rows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改数据</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
<div class="container my-5">
    <h1 class="display-2">编辑<?php echo $rows['name']; ?></h1>
    <?php if(isset($GLOBALS['message'])): ?>
        <h1 class="display-5"><?php echo $GLOBALS['message'] ?></h1>
    <?php endif ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $rows['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">名字</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo $rows['name'] ?>">
            <small class="form-text text-muted">请输入新名字</small>
        </div>
        <div class="form-group">选择性别
            <label for="gender">性别</label>
            <select name="gender" id="gender" class="form-control">
                <option value="-1">请选择性别</option>
                <option value="1"<?php echo $rows['gender']==='1'?' selected':''; ?> >男</option>
                <option value="0"<?php echo $rows['gender']==='0'?' selected':''; ?>>女</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birthday">出生日期</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="<?php echo $rows['birthday'] ?>">
            <small class="form-text text-muted">请输入生日</small>
        </div>
        <div class="form-group">
            <label for="avatar">头像</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
            <small class="form-text text-muted">请选择头像</small>
        </div>

        <button class="btn btn-block btn-primary">保存</button>
    </form>
</div>
</body>
</html>
