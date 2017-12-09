<?php
require_once("../helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$result = sqlExec("Exec login_user @username= $username , @password = $password");
if(empty($result)){
  $_SESSION['error'] = "Wrong combination of username and password";
  header("Location: /Database-Project/layout/appology.php");
  exit();
}else{
  $_SESSION['userid'] = $_POST['username'];
  $_SESSION['position'] = (array)sqlExec("Exec Find_Type @username= $username");
  $_SESSION['position'] = json_decode(json_encode(  $_SESSION['position']), true)[0]['tmp'];
  header("Location: /Database-Project/php/MainUserInterface.php");
  exit();
}

?>
