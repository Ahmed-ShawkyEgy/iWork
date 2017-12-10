<?php
// Check-out for today
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
if (session_status() == PHP_SESSION_NONE)
    session_start();


$result = (array)sqlExec("declare @o int
exec Check_Out @username = ".$_SESSION['userid']." , @out = @o output
select @o as 'out';");



$result = json_decode(json_encode($result), true)[0]['out'];


if($result != 1){
    $_SESSION['error'] = "Can't check out. Either today is your day off or you have already checked out today";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else if($result == 1)
{
    $_SESSION['accept'] = "Checked out successfully!";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
}
