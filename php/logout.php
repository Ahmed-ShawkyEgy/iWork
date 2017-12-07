<?php
session_start();
if($_SESSION['userid']  != null){
  $_SESSION['userid'] = null;
  $_SESSION['position'] = null;
  header("Location: /Database-Project/layout/MainPage.php");
  exit();
}
?>
