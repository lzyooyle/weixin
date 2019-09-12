<?php
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require ROOT."core/core.php";
$id=$_GET['id'];
$delete="delete from article where id=$id";
mysql_query($delete);
if($delete!=null){
	$echo="<script>alert('删除文章成功！');";
	$echo.="</script>";
	echo $echo;
}else{
	$echo1="<script>alert('删除文章失败，请联系管理员！');";
	$echo1.="</script>";
	echo $echo1;
}