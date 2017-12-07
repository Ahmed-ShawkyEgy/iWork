<?php
// Staff Member view his/her requests
// TODO create front end table to choose the request from it
// TODO create front end display for the result
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Crash";
$request_date = $_POST['req_date'];
// TODO add Session auth ie if($session == null) etc



$result = (array)sqlExec("declare @x int
exec Delete_Status_Requests @username=".$_SESSION['userid'].", @request_date=".$request_date." , @out = @x output
select @x as 'out'");



$result = json_decode(json_encode($result), true)[0]['out'];

if($result == 1)
{
    // Success !
}else
{
    // Fail :(
}
