<?php

if ($op == "edit") {
	include "patient.edit.php";
	exit;
} 
if ($op == "delete") {
	$ids = explode(",", $_GET["id"]);
	$del_ok = $del_bad = 0; $op_data = array();
	$del_name = array();
	foreach ($ids as $opid) {
		if (($opid = intval($opid)) > 0) {
			$tmp_data = $db->query_first("select * from $table where id='$opid' limit 1");
			if ($db->query("delete from $table where id='$opid' limit 1")) {
				$del_ok++;
				$op_data[] = $tmp_data;
				$del_name[] = $tmp_data["name"];
			} else {
				$del_bad++;
			}
		}
	}

	if ($del_ok > 0) {
	}

	if ($del_bad > 0) {
		msg_box("删除成功 $del_ok 条资料，删除失败 $del_bad 条资料。", "back", 1);
	} else {
		msg_box("删除成功", "back", 1);
	}
}