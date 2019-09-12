<?php 
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require ROOT."core/core.php";
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<title>文章发布页面</title>
    <link href="ueditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="ueditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/umeditor.min.js"></script>
    <script type="text/javascript" src="ueditor/lang/zh-cn/zh-cn.js"></script>	
</head>
<body>
	<form method='post' action='article.add.handle.php'>
		<table width='500' height='600' border='1'>
			<tr>
				<td align='center' colspan='2' height='50'>发布文章</td>
			</tr>	
			<tr>
				<td align='center'>标题:</td>
				<td><input type='text' name='title'></td>
			</tr>
			<tr>
				<td align='center'>作者:</td>
				<td><input type='text' name='author'></td>
			</tr>
			<tr>
				<td align='center'>简介:</td>
				<td><textarea cols='40' name='description' id='description'></textarea></td>
			</tr>
			<tr>
				<td align='center'>内容：</td>
				<td>    
				<textarea id="content" name='content' rows="10" cols="70" style="border:1px solid #E5E5E5;"></textarea>    
				<script type="text/javascript">
					    var um = UM.getEditor('content');
				</script>
				</td>
			</tr>
			<tr>
				<td colspan='2'><input type="submit" name="submit" value='提交文章' align='center'></td>
			</tr>
		</table>
	</form>
</body>
</html>