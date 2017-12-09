<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
/*
foreach ($_POST as $name => $value) {
   echo $name;
    print ('//');
   echo $value;
   print ('<br>');
}*/
$username = $_SESSION['userid'];
$job= post('job');
$department= post('department');
$company= post('company');

$result = sqlExec("Exec Delete_My_Applied_Job @username= '".$username."' , @title = $job,  @company= $company, @departement= $department");

$_SESSION['accept'] = "You have successfully deleted the application";
header("Location: /Database-Project/layout/acceptance.php");
exit();


?>
