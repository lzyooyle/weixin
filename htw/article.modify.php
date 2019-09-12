<?php
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require ROOT."core/core.php";
$id=$_GET['id'];
$select=mysql_query("select * from article where id = '$id'");
$data=mysql_fetch_assoc($select);
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<title>修改文章页面</title>
    <link href="ueditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="ueditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/umeditor.min.js"></script>
    <script type="text/javascript" src="ueditor/lang/zh-cn/zh-cn.js"></script>		
</head>
<body>
<form method="post" action='article.modify.handle.php'>
	<input type="hidden" name="id" value="<?php echo $data['id'] ?>">
	<table width="500" height="600" border="1">
		<tr>
			<td align='center' colspan='2' height="50">修改文章</td>
		</tr>
		<tr>
			<td align="center">标题：</td>
			<td><input type="text" name="title" value="<?php echo $data['title'] ?>"></td>
		</tr>
		<tr>
			<td align="center">作者：</td>
			<td><input type="text" name='author' value="<?php echo $data['author'] ?>"></td>
		</tr>
		<tr>
			<td align="center">简介：</td>
			<td><textarea cols="40" name="description" id="description"><?php echo $data['description'] ?></textarea></td>
		</tr>
		<tr>
			<td align="center">内容：</td>
			<td>
				<textarea id="content" name='content' rows="10" cols="70" style="border:1px solid #E5E5E5;"><?php echo $data['content'] ?></textarea>    
				<script type="text/javascript">
					    var um = UM.getEditor('content');
				</script>
			</td>
		</tr>
		<tr>
			<td colspan='2'><input type="submit" name="submit" value="提交修改" align="center"></td>
		</tr>
	</table>
</form>
</body>