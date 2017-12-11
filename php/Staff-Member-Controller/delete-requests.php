<?php
// Check in for today
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
if (session_status() == PHP_SESSION_NONE)
    session_start();

$date = date('Y-m-d', strtotime($_POST['date']));
echo $_POST['date'].'<br>';
//$date = date('Y-m-d', strtotime($_POST['date']));
//$date = str_replace('-','/',$date) ;
//$date = $date . substr($_POST['date'] , 10);
//echo $date ;

$result = (array)sqlExec("declare @output int
	Exec Delete_Status_Requests @username= '".$_SESSION['userid']."' ,@request_date = '".$date."', @out = @output output
	select @output as 'out';");

$result = json_decode(json_encode($result), true)[0]['out'];


if($result == 0 ){
//    $_SESSION['error'] = "Couldn't delete request<br>Either it doesn't exist or it has been accepted";
//    header("Location: /Database-Project/layout/appology.php");
//    exit();
}else
{
    $_SESSION['accept'] = "Request deleted succesfully !";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
}
