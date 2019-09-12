<?php
//先把连接数据库文件进行调用
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require ROOT."core/core.php";
//把前端的数据进行复制
$id=$_POST['id'];
$title=$_POST['title'];
$author=$_POST['author'];
$description=$_POST['description'];
$content=$_POST['content'];
//获取当前时间
$dateline=date('Y-M-D h:i:s',time());
//在提交数据之前，对用户输入的数据进行校验
if($title && $author && $description && $content!=null){
	$echo.="<script>alert('发表文章成功!');";
	$echo.="window.location.href='article.add.php';";
	$echo.="</script>";
	echo $echo;
}else{
	$echo1.="<script>alert('发表文章失败，请检查是否有内容为空！');";
	$echo1.="window.location.href='article.add.php';";
	$echo1.="</script>";
	echo $echo1;
}
//把数据进行入库
$update="update article set title='$title',author='$author',description='$description',content='$content',dateline='$dateline' where id='$id'";
$quert=mysql_query($update);