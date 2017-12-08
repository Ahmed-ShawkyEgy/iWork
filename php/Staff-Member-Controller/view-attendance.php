<?php
// View my attendance records between start-date and end-date
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
// TODO add Session auth ie if($session == null) etc

$result = (array)sqlExec("exec View_Attendance_Between_Certain_Period_Staff @SMusername = '".$_SESSION['userid']."' ,
@start_date = '".$start_date."' , @end_date = '".$end_date."'");

$result = json_decode(json_encode($result), true);


if(isset($result))
{
    // Success !
    echo 'success!';
    print_r($result);
}else
{
    // Fail :(
    echo 'fail';
}
