<?php
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require ROOT."core/core.php";
//require_once('../connect.php');
//对article表中的dateline(发布时间)进行倒序排序
$desc="select * from article order by dateline desc";
$quire=mysql_query($desc);
//如果这条数据存在并且数据条数大于0的话
if($quire && mysql_num_rows($quire)){
	//用while循环把数据依次输出并赋值交给变量row
	while($row=mysql_fetch_assoc($quire)){
		$data[]=$row;
	}
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<title>用户管理列表</title>
</head>
<body>
<table width="1600" border="1" align="center">
	<tr align="center">
		<td>编号</td>
		<td>标题</td>
		<td>分享的网址</td>		
		<td>更新时间</td>
		<td>操作</td>
	</tr>
	<?php 
	if(!empty($quire)){
		foreach($data as $value){
	?>
	<tr id='copy'>
		<td><?php echo $value['id']; ?></td>
		<td><?php echo $value['title']; ?></td>
		<td><?php echo "http://".$_SERVER['HTTP_HOST']."/m/patient/form.php?id=".$value['id'] ?></td>		
		<td><?php echo $value['dateline']; ?></td>
		<td><a href="article.info.php?id=<?php echo $value['id']; ?>">查看</a>&nbsp;&nbsp;<a href="article.del.handle.php?id=<?php echo $value['id']; ?>">删除</a>&nbsp;&nbsp;<a href="article.modify.php?id=<?php  echo $value['id']; ?>">修改</a>&nbsp;&nbsp;<a href="article.add.php?id=<?php echo $value['id']; ?>">添加</a></td>
	</tr>
	<?php 
		}
	}
	?>
</table>
</body>
</html>