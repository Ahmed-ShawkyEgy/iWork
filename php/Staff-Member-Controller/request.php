<?php
// Staff Member Apply for request
// TODO create front end form
// TODO create front end display
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
// TODO add Session auth ie if($session == null) etc

$username = $_POST['username'];
$start_date = $_POST['startDate'];
$end_date = $_POST['endDate'];
$type = $_POST['type'];
$usernameReplacement = $_POST['replacement'];


$result = (array)sqlExec("declare @x int
exec Apply_Request @username=".$username.",@start_date=".$start_date.", @end_date=".$end_date.",@type= ".$type.", @usernameReplacement=".$usernameReplacement." , @out = @x output
select @x as 'out'");



$result = json_decode(json_encode($result), true)[0]['out'];

if($result == 1)
{
    // Success !
}else
{
    // Fail :(
}
