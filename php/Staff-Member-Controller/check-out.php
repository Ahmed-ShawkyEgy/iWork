<?php

require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
// TODO add Session auth

$result = (array)sqlExec("declare @o int
exec Check_Out @username = ".$_SESSION['userid']." , @out = @o output
select @o as 'out';");



$result = json_decode(json_encode($result), true)[0]['out'];


if($result == 0 ){
    $_SESSION['error'] = "Can't check out. Either today is your day off or you have already checked out today";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else if($result == 1)
  print_r("checked out successfully!");
else if($result == 2) print_r("Already checked out");
