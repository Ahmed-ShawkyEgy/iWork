<?php
require("../helper/sqlExec.php");
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$result = sqlExec("Exec login_user @username= $username , @password = $password");
if(empty($result)){
  echo "FUCK YOU!!!!!! Fuck OFFF!!";
}else{
  $_SESSION['userid'] = $_POST['username'];
  $_SESSION['position'] = sqlExec("Exec Find_Type @username= $username")[0];
  header("Location: /Database-Project/layout/profile.php");
  exit();
}

//

?>
