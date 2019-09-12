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
            var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
            if (!myreg.test(oForm.tel.value)) {
                alert("手机号码有误，请重填"); oForm.tel.focus(); return false;
            } else {
                return true;
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

//var html = '<button class="btn btn-primary" data-toggle="modal" data-target="#addcase">马上报名</button>';
var html = '<img src="CBnIcw8NgG-compress.jpg" class="img-responsive" alt="Cinque Terre" data-toggle="modal" data-target="#addcase">';
//$("section").after(html);
$('section').each(function(i){
    var num = i+1;
    if(num%11 == 0){
        $(this).after(html);
    }
})
 $(function(){
 $('#sub').click(function(){
  var name=$('#name').val();
  var tel=$('#tel').val();
  var kehu_id=$('#kehu_id').val();
  var nickname=$('#nickname').val();
  var sex=$('#sex').val();
  var province=$('#province').val();
  var city=$('#city').val();
  var from_id=$('#from_id').val();
  var from_nickname=$('#from_nickname').val();
  $.ajax({
  type: "post",
  url: "add.handle.php",
  data: {name:name,tel:tel,kehu_id:kehu_id,sex:sex,nickname:nickname,province:province,city:city,from_id:from_id,from_nickname:from_nickname}, 
  success: function(msg){
	  $("input").val('');
	  alert("资料提交成功!");
  },
  error:function(msg){
   alert("资料提交失败，系统繁忙，请稍后再试。");
  }

  });

 });

 })
</script>
                            <div id="addcase" class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" style="top:30%;">
                                <!-- <form action="add.handle.php" name="mainform" method="POST" onSubmit="return check_data()"> -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">在线报名</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="InputCode">姓名：</label>
                                                <input type="text" class="form-control" name="name" id="name" onChange="check_repeat('name', this)" placeholder="请输入您的姓名">
                                            </div>
                                            <div class="form-group">
                                                <label for="InputCode">手机号：</label>
                                                <input type="text" class="form-control" name="tel" id="tel" onChange="check_repeat('name', this)" placeholder="请输入您的手机号">
                                            </div>											
                                                <input type="hidden" title="客户id" name="kehu_id" id="kehu_id" value="<?=$user['openid']?>">
                                                <input type="hidden" title="客户的昵称" name="nickname" id="nickname" value="<?=$user['nickname']?>">											
                                                <input type="hidden" title="性别" name="sex" id="sex" value="<?php 
													switch (strtoupper($user['sex'])){
														case 1:
															 echo '男性';
															break;
														case 2:
															 echo '女性';
															break;
														default:
															 echo '未知';
															break;
													}												
												?>">
                                                <input type="hidden" title="省份" name="province" id="province" value="<?=$user['province']?>">
                                                <input type="hidden" title="城市" name="city" id="city" value="<?=$user['city']?>">
                                                <input type="hidden" title="分享人id" name="from_id" id="from_id" value="<?=$_GET['from_openid']?>">
                                                <input type="hidden" title="分享人的昵称" name="from_nickname" id="from_nickname" value="<?=$_GET['from_nickname']?>">
                                        <div class="modal-footer">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                                                <button type="submit" id="sub" class="btn btn-primary">提交</button>
                                            </div>
                                        </div>
                                    </div>
                                <!--  </form> -->
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->	

<div class="clear"></div>

<div class='crf_fot'>

</div>
