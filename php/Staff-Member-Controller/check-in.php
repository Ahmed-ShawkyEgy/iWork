<?php
// Check in for today
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
if (session_status() == PHP_SESSION_NONE)
    session_start();

$result = (array)sqlExec("declare @output int
	Exec Check_In @username= '".$_SESSION['userid']."' , @out = @output output
	select @output as 'out';");

$result = json_decode(json_encode($result), true)[0]['out'];


if($result == 0 ){
    $_SESSION['error'] = "Can't check in\n either today is your day off or you have already checked in today";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else
{
    $_SESSION['accept'] = "Checked in Successfully!";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
}
