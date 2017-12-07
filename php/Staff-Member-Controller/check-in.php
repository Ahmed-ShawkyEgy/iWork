<?php
// Check in for today
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
// TODO add Session auth

$result = (array)sqlExec("declare @output int
	Exec Check_In @username= ".$_SESSION['userid']." , @out = @output output
	select @output as 'out';");

$result = json_decode(json_encode($result), true)[0]['out'];


if($result == 0 ){
    $_SESSION['error'] = "Can't check in\n either today is your day off or you have already checked in today";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else
  print_r("Checked in Successfully!");
