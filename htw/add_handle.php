<?php
$link_param = explode(" ", "page sort order key begin_time end_time zhuanjia ty_time media time_type show come kefu_23_name btime etime selectt selects selectr media_search account_search kefu_4_name doctor_name xiaofei disease part_id from depart names date");
$param = array();
foreach ($link_param as $s) {
	
	
	$param[$s] = $_GET[$s];
}
$cko = $_GET["cko"];
//echo $op;
extract($param);
//echo $uinfo["part_id"];
if($uinfo["part_id"]==2){
$list_heads = array(
	"省份" => array("align"=>"center", "sort"=>"province", "order"=>"asc"),	
	"操作" => array("width"=>"80", "align"=>"center"),
);	
}else{
$list_heads = array(
	"客户姓名" => array("align"=>"center", "sort"=>"name", "order"=>"asc"),
	"客户手机号" => array("align"=>"center", "sort"=>"tel", "order"=>"asc"),
	"客户id" => array("align"=>"center", "sort"=>"kehu_id", "order"=>"asc"),
	"客户的昵称" => array("align"=>"center", "sort"=>"nickname", "order"=>"asc"),
	"性别" => array("align"=>"center", "sort"=>"sex", "order"=>"asc"),
	"省份" => array("align"=>"left", "sort"=>"province", "order"=>"asc"),	
	"城市" => array("align"=>"left", "sort"=>"city", "order"=>"asc"),	
	"分享人id" => array("align"=>"left", "sort"=>"from_id", "order"=>"asc"),	
	"分享人的昵称" => array("align"=>"left", "sort"=>"from_nickname", "order"=>"asc"),	
	"提交日期" => array("align"=>"left", "sort"=>"order_date", "order"=>"asc"),	

	
	"操作" => array("width"=>"80", "align"=>"center"),
);
}

if ($uinfo["part_id"] == 4) {
	$default_sort = "预约时间";
	$default_order = "desc";
} else {
	$default_sort = "添加时间";
	$default_order = "desc";
}
$t = load_class("table");
$t->set_head($list_heads, $default_sort, $default_order);
$t->set_sort($_GET["sort"], $_GET["order"]);
$t->param = $param;
$t->table_class = "table";
$sqlsort = $db->make_sort($list_heads, $sort, $order, $default_sort, $default_order);
$time = time();
$today_begin = mktime(0,0,0);
$today_end = $today_begin + 24 * 3600;
$where = array();
if(IS_POST){
	if(empty($key)){
		$key=$_POST['key'];	
	}
}
if ($key = trim(stripslashes($key))) {
	$sk = "%{$key}%";
	$fields = explode(" ", "name tel kehu_id nickname sex province city  from_id from_nickname order_date");
	$sfield = array();
	foreach ($fields as $_tm) {
		$sfield[] = "binary $_tm like '{$sk}'";
	}
	$where[] = "(".implode(" or ", $sfield).")";
}
if ($depart != '') {
	$where[] = "depart=$depart";
}
$sqlwhere = $db->make_where($where);
$sqlsort = $db->make_sort($list_heads, $sort, $order, $default_sort, $default_order);
$count = $db->query("select count(*) as count from $table $sqlwhere $sqlgroup", 1, "count");
$pagecount = max(ceil($count / $pagesize), 1);
$page = max(min($pagecount, intval($page)), 1);
$offset = ($page - 1) * $pagesize;
$list_data = $db->query("select *,(order_date-$time) as remain_time, if(order_date<$today_begin, 1, if(order_date>$today_end, 2, 3)) as order_sort, if(status=1,2, if(status=2,1,0)) as status_1 from $table $sqlwhere $sqlgroup $sqlsort limit $offset,$pagesize");
$depart_id_name = $db->query("select id,name from depart where hospital_id=$user_hospital_id", 'id', 'name');
foreach ($list_data as $li) {
	$id = $li["id"];
	if ($id == 0) {
		$t->add_tip_line($li["name"]);
	} else {
		$r = array();
		$r["客户姓名"] = $li["name"];
		$r["客户手机号"] = $li["tel"];
		$r["客户id"] = $li["kehu_id"];
		$r["客户的昵称"] = $li["nickname"];
		$r["性别"] = $li["sex"];
		$r["省份"] = $li["province"];
		$r["城市"] = $li["city"];

		
		$r["分享人的昵称"] = $li["from_nickname"];
		$r["分享人id"] = $li["from_id"];
		$r["提交日期"] = date("Y-m-d H:i:s", $li["order_date"]);
		
		
		
		
		$op = array();
 		if (check_power("view")) {
			
		} 
		$can_edit = 0;
		
		if ($uinfo["part_id"] == 2) {			
			
				$can_edit = 1;
			
		} else if ($uinfo["part_id"] == 3) {
			$can_edit = 1;
		} else {
			$can_edit = 1;
		}
		
			//echo $cko;
		if ((check_power("edit") && $can_edit) || $debug_mode) {
			
			//echo $li["status"];
			//echo $uinfo["part_id"];
			//aecho $uinfo["part_id"]==1 && $cko==173?'ok':'no';
			//echo $uinfo["part_id"]==1 && $cko==173?'ok':'no';
			if($li["status"] == 1){
				if($uinfo["part_id"]==9){
					
				$op[] = "<a href='?op=edit&id=$id&go=back' class='op'><button type='button' class='btn btn-info'>编辑</button></a>";
				}else{
				if($uinfo["part_id"]==1 && $cko==173){				
				$op[] = "<a href='?op=edit&id=$id&go=back' class='op'>查看</a>";
				}else{
				$op[] = "<a href='?op=edit&id=$id&go=back' class='op'><button type='button' class='btn btn-info'>编辑</button></a>";
				}
				}
			}else{
				
				//echo $id;
				//if($uinfo["part_id"]!=1){
				if($uinfo["part_id"]==1 && $cko==173){				
				$op[] = "<a href='?op=edit&id=$id&go=back&cko=373' class='op'>查看</a>";
				}else{
				$op[] = "<a href='?op=edit&id=$id&go=back' class='op'><button type='button' class='btn btn-info'>编辑</button></a>";
				}
				
				//$op[] = "<a href='?op=edit&id=$id&go=back' class='op'>修改</a>";
				//}
			}
		}
		$can_delete = 0;
		check_power("delete");
		if (check_power("delete")) {
			
			
			$can_delete = 1;
			if ($li["author"] == $realname) {
				if ($li["status"] == 0 && $line["edit_log"] == '') {
					$can_delete = 1;
				}
			} else {
				if (in_array($uinfo["part_id"], array(1,9)) || $uinfo["part_admin"]) {
					$can_delete = 1;
				}
			}
		}
		
		
		if ($can_delete == 1 || $debug_mode) {
			
			if($uinfo["part_id"]==9){
			}
		}
		$r["操作"] = implode(" ", $op);
		
		$_tr = ' id="#'.$li["id"].'"';
		$color_status = $li["status"];
		if ($color_status == 0 && date("Ymd", $li["order_date"]) < date("Ymd")) {
			$color_status = 3;
		}
		if ($color_status == 0 && $li["huifang"] != '') {
			$color_status = 4;
		}
		$color = $line_color[$color_status];
		if ($li["order_date"] > strtotime("+2 month")) {
			$color = "#FF00FF";
		}
		if ($li["order_date"] =="0") {
			//$color = "#0000ff";
		}
		$_tr .= ' style="color:'.$color.'"';
		$r["_tr_"] = $_tr;
		$t->add($r);
	}
}


$pagelink = pagelinkc($page, $pagecount, $count, make_link_info($link_param, "page"), "button");
include $mod.".list.tpl.php";
