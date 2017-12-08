<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
if($_SESSION['userid'] == null)
  session_start();
if($_SESSION['userid'] == null){

echo '<a href="accesslayout.php">  <button  type="button" class="btn btn-default">Login</button></a>
<a href="Register.php">  <button href="Register.php" type="button" class="btn btn-default">Register</button></a>';
}
/*
<a href="accesslayout.php">  <button  type="button" class="btn btn-default">Login</button></a>
<a href="Register.php">  <button href="Register.php" type="button" class="btn btn-default">Register</button></a>
*/
 ?>
