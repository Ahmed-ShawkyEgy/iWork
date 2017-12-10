<?php
// Check in for today
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Ves";
// TODO add Session auth

$recipient = $_POST['recipient'];
$subject = $_POST['subject'];
$body = $_POST['body'];

$result = (array)sqlExec("declare @o int
exec Send_Email @username='".$_SESSION['userid']."',@recipient='Trissy',@subject='".$subject."',@body='".$body."' , @out = @o output
select @o as 'out';");

$result = json_decode(json_encode($result), true)[0]['out'];


if($result == 0 ){
    // Fail
    $_SESSION['error'] = "Can't send to this user";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}else{
    // Sucess
    $_SESSION['accept'] = "Email sent successfully!";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
}
