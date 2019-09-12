<?php
include_once "../../core/core.php";
$mod = "patient";
$table = "patient_".$user_hospital_id;
//echo $user_hospital_id;
//echo 'tony';
//msg_box("资料提交成功", '/m/patient/patient.php', 1);	
$cko = $_GET["cko"];
$mode = $op;
if ($_POST) {
$po=&$_POST;
if ($mode == "edit") {
		$oldline = $db->query("select * from $table where id=$id limit 1", 1);
	}else {

}
$province=trim($po['province']);
if(isset($po['order_date'])){
	$order_date_post=date('Y-M-D h:i:s',time());
}
if(isset($po['sex'])){
	$sex_post=strtotime($po['sex']);
}
//echo 'tony';
//$status=$po['status'];
//$cost=$po['cost'];
//$remark=$po['remark'];
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
//$r['status']=$status;
//$r['cost']=$cost;
//var_dump($r);
//echo 'tony';
//echo $mode;
//exit();
$sqldata=$db->sqljoin($r);
//exit();
	if ($mode == "edit") {
		$sql = "update $table set $sqldata where id='$id' limit 1";
		//exit();
	} else {
		$sql = "insert into $table set $sqldata";
	}
//echo 'tony'	;
//msg_box("资料提交成功", history(2, $id), 1);	
echo $return=$db->query($sql);
//exit($return);
	if ($return) {
		if ($op == "add") $id = $return;
		msg_box("资料提交成功", '/m/patient/patient.php', 1);
		//var_dump($_POST);
	} else {
		msg_box("资料提交失败，系统繁忙，请稍后再试。", "back", 1, 5);
	}
}
if ($mode == "edit") {
	$line = $db->query_first("select * from $table where id='$id' limit 1");
	//var_dump($line["remark3"]);
}
?>

	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  	
    <link key="index" href="/res/index.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>	
<script language="javascript">
function check_data() {
	var oForm = document.mainform;
	if (oForm.name.value == "") {
		alert("请输您的姓名！"); oForm.name.focus(); return false;
	}
	if (oForm.tel.value == "") {
		alert("请输您的手机号码！"); oForm.tel.focus(); return false;
	}

	return true;
}


function check_repeat(type, obj) {
	if (!byid("id") || (byid("id").value == '0' || byid("id").value == '')) {
		var value = obj.value;
		if (value != '') {
			var xm = new ajax();
			xm.connect("/http/check_repeat.php?type="+type+"&value="+value+"&r="+Math.random(), "GET", "", check_repeat_do);
		}
	}
}

function check_repeat_do(o) {
	var out = ajax_out(o);
	if (out["status"] == "ok") {
		if (out["tips"] != '') {
			alert(out["tips"]);
		}
	}
}


</script>
<body>
<div class='content'>
		<?php 
			require ROOT.'/res/left.php';
		?>
		<div class='c_fr'>
		<?php 
			require ROOT.'/res/head.php';
		?>
			<div class='nav'>
<?php 
if ($mode == "edit") {
?>	
				<div class='fl'>
					修改客户信息
				</div>
				<div class='fr'>
					<a href='/'>首页</a> / 修改信息
				</div>
<?php 
}else{
?>		
				<div class='fl'>
					添加客户信息
				</div>
				<div class='fr'>
					<a href='/'>首页</a> / 添加信息
				</div>		
<?php 
}
?>				

			</div>
			<div class='clear'></div>		
			<div class='wd12'>
			<div class="col-md-12 col-lg-12 c6">
<form name="mainform" method="POST" onSubmit="return check_data()">
<?php 
//echo $uinfo["part_id"]; 
if($uinfo["part_id"]==373 || $cko==373){
?>

<?php }else{ ?>
<?php
if ($mode == "edit") {
?>	
<div style='margin:3% 0 0 3%'>
<div class="col-md-4 col-lg-4">姓名：<input name="name" id="name" value="<?php echo $line["name"]; ?>" class="form-control"  <?php echo $ce["name"]; ?> onChange="check_repeat('name', this)"> </div>
<div class="col-md-4 col-lg-4">客户手机号：<input name="tel" id="tel" value="<?php echo $line["tel"]; ?>" class="form-control"  <?php echo $ce["tel"]; ?> onChange="check_repeat('tel', this)"> </div>
<div class="col-md-4 col-lg-4">客户id：<input name="kehu_id" id="kehu_id" value="<?php echo $line["kehu_id"]; ?>" class="form-control"  <?php echo $ce["kehu_id"]; ?> onChange="check_repeat('kehu_id', this)"> </div>

<div class="ht2 clear"></div>
<div class="col-md-4 col-lg-4">客户的昵称：<input name="nickname" id="nickname" value="<?php echo $line["nickname"]; ?>" class="form-control"  <?php echo $ce["nickname"]; ?> onChange="check_repeat('nickname', this)"> </div>
<div class="col-md-4 col-lg-4">性别：<input name="sex" id="sex" value="<?php echo $line["sex"]; ?>" class="form-control"  <?php echo $ce["sex"]; ?> onChange="check_repeat('sex', this)"> </div>
<div class="col-md-4 col-lg-4">省份：<input name="province" id="province" value="<?php echo $line["province"]; ?>" class="form-control"  <?php echo $ce["province"]; ?> onChange="check_repeat('province', this)"> </div>
<div class="ht2 clear"></div>
<div class="col-md-4 col-lg-4">城市：&nbsp;&nbsp;&nbsp;<input name="city" id="city" value="<?php echo $line["city"]; ?>" class="form-control"  <?php echo $ce["city"]; ?> onChange="check_repeat('city', this)"> </div>
<div class="col-md-4 col-lg-4">分享人id：&nbsp;&nbsp;&nbsp;<input name="from_id" id="from_id" value="<?php echo $line["from_id"]; ?>" class="form-control"  <?php echo $ce["from_id"]; ?> onChange="check_repeat('from_id', this)"> </div>
<div class="col-md-4 col-lg-4">分享人的昵称：&nbsp;&nbsp;&nbsp;<input name="from_nickname" id="from_nickname" value="<?php echo $line["from_nickname"]; ?>" class="form-control"  <?php echo $ce["from_nickname"]; ?> onChange="check_repeat('from_nickname', this)"> </div>

<div class="ht2 clear"></div>
<div class="col-md-12 col-lg-12 c6">	
<div class="col-md-4 col-lg-4"></div>
<div class="col-md-1 col-lg-1"><input type="submit" id="submit" class="submit btn btn-info btn-lg" value="提交"></div>
<div class="col-md-1 col-lg-1" style='padding-left:7px;'><input class="submit btn btn-default btn-lg" onclick="window.history.go(-1)" value="取消"></div>
</div>
</div><?php	
}else{
?>
<div style='margin:3% 0 0 3%'>
<div class="col-md-4 col-lg-4">姓名：<input name="name" id="name" value="<?php echo $line["name"]; ?>" class="form-control"  <?php echo $ce["name"]; ?> onChange="check_repeat('name', this)"> </div>
<div class="col-md-4 col-lg-4">客户手机号：<input name="tel" id="tel" value="<?php echo $line["tel"]; ?>" class="form-control"  <?php echo $ce["tel"]; ?> onChange="check_repeat('tel', this)"> </div>
<div class="col-md-4 col-lg-4">客户id：<input name="kehu_id" id="kehu_id" value="<?php echo $line["kehu_id"]; ?>" class="form-control"  <?php echo $ce["kehu_id"]; ?> onChange="check_repeat('kehu_id', this)"> </div>

<div class="ht2 clear"></div>
<div class="col-md-4 col-lg-4">客户的昵称：<input name="nickname" id="nickname" value="<?php echo $line["nickname"]; ?>" class="form-control"  <?php echo $ce["nickname"]; ?> onChange="check_repeat('nickname', this)"> </div>
<div class="col-md-4 col-lg-4">性别：<input name="sex" id="sex" value="<?php echo $line["sex"]; ?>" class="form-control"  <?php echo $ce["sex"]; ?> onChange="check_repeat('sex', this)"> </div>
<div class="col-md-4 col-lg-4">省份：<input name="province" id="province" value="<?php echo $line["province"]; ?>" class="form-control"  <?php echo $ce["province"]; ?> onChange="check_repeat('province', this)"> </div>
<div class="ht2 clear"></div>
<div class="col-md-4 col-lg-4">城市：&nbsp;&nbsp;&nbsp;<input name="city" id="city" value="<?php echo $line["city"]; ?>" class="form-control"  <?php echo $ce["city"]; ?> onChange="check_repeat('city', this)"> </div>
<div class="col-md-4 col-lg-4">分享人id：&nbsp;&nbsp;&nbsp;<input name="from_id" id="from_id" value="<?php echo $line["from_id"]; ?>" class="form-control"  <?php echo $ce["from_id"]; ?> onChange="check_repeat('from_id', this)"> </div>
<div class="col-md-4 col-lg-4">分享人的昵称：&nbsp;&nbsp;&nbsp;<input name="from_nickname" id="from_nickname" value="<?php echo $line["from_nickname"]; ?>" class="form-control"  <?php echo $ce["from_nickname"]; ?> onChange="check_repeat('from_nickname', this)"> </div>

<div class="ht2 clear"></div>
<div class="col-md-12 col-lg-12 c6">	
<div class="col-md-4 col-lg-4"></div>
<div class="col-md-1 col-lg-1"><input type="submit" id="submit" class="submit btn btn-info btn-lg" value="提交"></div>
<div class="col-md-1 col-lg-1" style='padding-left:7px;'><input class="submit btn btn-default btn-lg" onclick="window.history.go(-1)" value="取消"></div>
</div>
</div>
<?php	
}
?>	
<?php } ?>

</table>


</form>
	
	</div>		
	</div>		

<div class="clear"></div>

<div class='crf_fot'>


</div>
<div class="space"></div>

</div>
</div>	
</body>