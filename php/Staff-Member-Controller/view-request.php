<?php
// Staff Member view his/her requests
// TODO create front end form
// TODO create front end display
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Trissy";
// TODO add Session auth ie if($session == null) etc



$result = (array)sqlExec("exec View_All_Status_Requests @username = ".$_SESSION['userid']."");



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
