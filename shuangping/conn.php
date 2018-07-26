<?php
	 //$mysqli=new mysqli("localhost", "root", "", "data1002_fanxunran");
	//$mysqli=new mysqli("183.131.144.29", "admin", "Issmart@123", "test");
	 $mysqli=new mysqli("dbserver", "root", "Huawei$123#_", "event");
	if($mysqli->connect_errno){
		$json['msg'] = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else{
		$mysqli->set_charset("utf8");
	}

?>
