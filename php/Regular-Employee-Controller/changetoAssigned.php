<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
/*foreach ($_POST as $name => $value) {
   echo $name;
    print ('//');
   echo $value;
   print ('<br>');
}*/

$searchOption=post('searchOption');
$project=  $_SESSION['projx'];
$username=$_SESSION['userid'];
//echo $username;
$result=sqlExec("Exec Change_Status_To_Assigned_Again @username='".$username."',@project=$project, @task=$searchOption");
if(empty($result)){
  $_SESSION['error'] = "Either the task deadline has passed <br> or the status of the task is not Fixed";
  header("Location: /Database-Project/layout/appology.php");
  exit();
}
else{$_SESSION['accept'] = "You have successfully changed the status of the task to Assigned";
header("Location: /Database-Project/layout/acceptance.php");
exit();
}

?>
