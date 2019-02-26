<?php
/**
 * Created by PhpStorm.
 * User: Nymeria
 * Date: 2018/9/22 0022
 * Time: 下午 03:49
 */
require_once 'config.php';
require_once 'function.php';
function add_users(){
    $data=array();
    $data['id']=uniqid();
    //接收并校验
//================校验标题=================
    if(empty($_POST['name'])){
        $GLOBALS['message']='请输入名字';
        return;
    }
    $data['name']=$_POST['name'];
//================校验性别==================
    if(!isset($_POST['gender'])){
        $GLOBALS['message']='请选择性别';
        return;
    }
    $data['gender']=$_POST['gender'];
    //================校验生日==================
    if(empty($_POST['birthday'])){
        $GLOBALS['message']='请选择生日';
        return;
    }
    $data['birthday']=$_POST['birthday'];
    //==============校验海报====================
    if(empty($_FILES['avatar'])){
        $GLOBALS['message']='请选择头像';
        return;
    }
    $avatar=$_FILES['avatar'];
//    var_dump($avatar);
//        上传单张海报
        if($avatar['error']!== UPLOAD_ERR_OK){
            $GLOBALS['message']='海报上传失败';
            return;
        }
        //    对海报格式进行检验
        if($avatar['size']>5*1024*1024){
            $GLOBALS['message']='海报大小不符要求';
            return;
        }
//    对海报格式进行检验
        $allowavatar_type=array('image/jpeg','image/jpg','image/png','image/gif');
        if(!in_array($avatar['type'],$allowavatar_type)){
            $GLOBALS['message']='海报格式不符要求';
            return;
        }
        $initial_avatar=$avatar['tmp_name'];
        $target_avatar='../images/'.uniqid().$avatar['name'];
        $moved_avatar=move_uploaded_file($initial_avatar,$target_avatar);
        if(!$moved_avatar){
            $GLOBALS['message']='海报上传失败';
            return;
        }
        $data['avatar']=$target_avatar;
        $rows=fetch_all('select * from users');
        // var_dump($rows);
        var_dump($data);
		$name=$data['name'];
		$gender=$data['gender'];
		$birthday=$data['birthday'];
		$avatar=substr($data['avatar'],2);
		
		// echo ('insert into users values(null,"{$data[`name`]}","{$data['gender']}","{$data['birthday']}","{$data['avatar']}");');
		// $sql = 'insert into users values (null,{$data["name"]},{$data["gender"]},{$data["birthday"]},{$data["avatar"]})';
		// var_dump($sql);
        // $affected_rows=execute("insert into users values (null," . $name . "," . $gender . "," . $birthday . "," . $avatar . ");");
		// $affected_rows=execute("insert into users values (null, '{$name}',{$gender},{$birthday},{$avatar});");
		$affected_rows=execute("insert into users values (null, '{$name}',{$gender},'{$birthday}','{$avatar}');");
		// $affected_rows=execute($sql);
        var_dump($affected_rows);
    header('Location: 数据库操作.php');
}

if($_SERVER['REQUEST_METHOD']==="POST"){
    add_users();
//    var_dump($_POST);
}




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
<div class="container my-5">
    <h1 class="display-2">添加新用户</h1>
    <?php if(isset($GLOBALS['message'])): ?>
        <h1 class="display-5"><?php echo $GLOBALS['message'] ?></h1>
    <?php endif ?>
    <table class="table table-bordered table-striped table-hover">
        <tbody>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">名字</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <small class="form-text text-muted">请输入用户名字</small>
                </div>
                <div class="form-group">选择性别
                    <input type="radio" name='gender'id="sex" value="0">男
                    <input type="radio" name="gender" id="sex" value="1">女
                    <small class="form-text text-muted">请选择性别</small>
                </div>
                <div class="form-group">
                    <label for="birthday">出生日期</label>
                    <input type="date" name="birthday" id="birthday" class="form-control">
                    <small class="form-text text-muted">请输入生日</small>
                </div>
                <div class="form-group">
                    <label for="avatar">头像</label>
                    <input type="file" name="avatar" id="avatar" class="form-control">
                    <small class="form-text text-muted">请选择头像</small>
                </div>

                <button class="btn btn-block btn-primary">保存</button>
            </form>
        </tbody>
    </table>
</body>
</html>