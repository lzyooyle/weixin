<?php
define("ROOT", str_replace("\\", "/", dirname(dirname(dirname(__FILE__))))."/");
require_once('../connect.php');
require ROOT.'core/config.php';
require ROOT.'core/class.mysql.php';
require ROOT.'core/function.php';
$db=new mysql($mysql_server);
$table = "patient_10";
if ($_POST) {
$po=&$_POST;
$province=trim($po['province']);
if(isset($po['order_date'])){
	$order_date_post=date('Y-M-D h:i:s',time());
}
if(isset($po['sex'])){
	$sex_post=strtotime($po['sex']);
}

$r=array();
if(isset($po['province'])) $r['province']=trim($po['province']);
$r['order_date']=time();
if(isset($po['name'])) $r['name']=trim($po['name']);
if(isset($po['kehu_id'])) $r['kehu_id']=$po['kehu_id'];
if(isset($po['nickname'])) $r['nickname']=$po['nickname'];
if(isset($po['from_nickname'])) $r['from_nickname']=trim($po['from_nickname']);
$r['sex']=$sex_post;
if(isset($po['from_id'])) $r['from_id']=trim($po['from_id']);
if(isset($po['city'])) $r['city']=trim($po['city']);
if(isset($po['tel'])) $r['tel']=trim($po['tel']);
if(isset($po['sex'])) $r['sex']=trim($po['sex']);
$sqldata=$db->sqljoin($r);
$sql = "insert into $table set $sqldata";
$return=$db->query($sql);
	if ($return) {
		msg_box("资料提交成功", 'back', 1);
	} else {
		msg_box("资料提交失败，系统繁忙，请稍后再试。", "back", 1, 5);
	}
}
?>