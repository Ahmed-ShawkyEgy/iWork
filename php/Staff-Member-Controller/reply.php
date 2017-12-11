<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");


$subject = $_POST['subject'];
$body = $_POST['body'];
$id = $_POST['id'];

$result = (array)sqlExec("declare @o int
exec Reply_Email @username='".$_SESSION['userid']."',@emailId = ".$id.",@subject='".$subject."',@body='".$body."' , @out = @o output
select @o as 'out';");


$result = json_decode(json_encode($result), true)[0]['out'];

if($result == 1)
{
    $_SESSION['accept'] = "Email sent succesfully !";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
}
else{
    $_SESSION['error'] = "Email couldn't be sent";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}
