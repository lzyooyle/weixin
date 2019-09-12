<?php
require '../../core/core.php';
$mod = "patient";
$table = "patient_".$user_hospital_id;
$line_color_tip = array("等待", "已到", "未到", "过期", "回访");
if ($op = $_GET["op"]) {
	include "patient.op.php";
}
include "patient.list.php";