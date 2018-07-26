<?php

include 'conn.php';
$num=$_POST['num'];
$sql="SELECT status FROM test_1024 WHERE num=$num";

$hbo = $mysqli->query($sql);
$followingdata = $hbo->fetch_assoc();
echo json_encode($followingdata);
?>
