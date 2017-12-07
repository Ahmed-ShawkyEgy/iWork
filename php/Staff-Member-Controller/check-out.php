<?php
// Check-out for today
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
// TODO add Session auth ie if($session == null) etc

$result = (array)sqlExec("declare @o int
exec Check_Out @username = ".$_SESSION['userid']." , @out = @o output
select @o as 'out';");



$result = json_decode(json_encode($result), true)[0]['out'];


if($result != 1){
    $_SESSION['error'] = "Can't check out. Either today is your day off or you have already checked out today";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else if($result == 1)
  print_r("checked out successfully!");
