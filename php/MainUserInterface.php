<?php
require_once("../helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
print_r( $_SESSION['position']);
if($_SESSION['userid'] == null){
  header("Location: /Database-Project/layout/accesslayout.php");
  exit();
}
if($_SESSION['position']=='manager'){
  header("Location: /Database-Project/layout/profile.php");
  exit();
}
if($_SESSION['position']=='regular_employee'){
header("Location: /Database-Project/layout/Regular Employee/profile.php");
exit();
}
if($_SESSION['position']=='job_seeker'){
header("Location: /Database-Project/layout/Job Seeker/profile.php");
exit();
}
if($_SESSION['position']=='hr_employee'){
  header("Location: /Database-Project/layout/profile.php");
  exit();
}
?>
