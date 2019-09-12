<meta name="referrer" content="no-referrer" />
<?php
require_once('../connect.php');
$id=$_GET['id'];
$select=mysql_query("select * from article where id = '$id'");
$data=mysql_fetch_assoc($select);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $data['title'] ?></title>
</head>
<body>
<?php
header("Content-type: text/html; charset=utf-8");
$url = $data['description'];
$info=file_get_contents($url);
$t1 = 'data-src';
$t2 = 'https://mmbiz.qpic.cn/';
$t3 = 'class="qr_code_pc"';
$res=str_replace($t1,'src',$info);
$res=str_replace($t2,'http://img01.store.sogou.com/net/a/04/link?appid=100520029&url=https://mmbiz.qpic.cn/',$res);
$res=str_replace($t3,'class="qr_code_pc" style="display:none;"',$res);
echo $res;
?>
</body>