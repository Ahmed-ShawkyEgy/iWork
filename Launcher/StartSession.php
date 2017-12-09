<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE){
  session_start();
  $_SESSION['userid'] = null;
}
header("Location: /Database-Project/layout/MainPage.php");
exit();
?>
