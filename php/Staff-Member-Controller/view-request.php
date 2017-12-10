<?php
// Staff Member view his/her requests
// TODO create front end form
// TODO create front end display
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
if (session_status() == PHP_SESSION_NONE)
    session_start();




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
