<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
$username = $_SESSION['userid'];
$job= $_SESSION['title'];
$department= $_SESSION['department'];
$company= $_SESSION['company'];
$searchOption = $_POST['searchOption'];
if($searchOption != 'dayoff'){
if (strpos($_SESSION['title'], 'Manager') !== false){
  $managerType=post('ManagerType');
  $result = sqlExec("Exec Select_Job @username= '".$username."' , @title = '".$job."',  @company= '".$company."', @departement= '".$department."', @dayoff='".$searchOption."',@managerType=$managerType");
}else
$result = sqlExec("Exec Select_Job @username= '".$username."' , @title = '".$job."',  @company= '".$company."', @departement= '".$department."', @dayoff='".$searchOption."'");
$_SESSION['position'] = null;
$_SESSION['position'] = (array)sqlExec("Exec Find_Type @username= $username");
$_SESSION['position'] = json_decode(json_encode(  $_SESSION['position']), true)[0]['tmp'];
$_SESSION['accept'] = "You have successfully selected a job <br> Welcome To The Family";
header("Location: /Database-Project/layout/acceptance.php");
exit();
}
else{
  $_SESSION['error'] = "Dayoff isnt a valid option for the dayoff";
  header("Location: /Database-Project/layout/appology.php");
  exit();
}
?>
