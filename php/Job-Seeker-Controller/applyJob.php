<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();


$username = $_SESSION['userid'];
$title = $_POST['title'];
$company = $_POST['company'];
$department = $_POST['department'];


$result = sqlExec("Exec Apply_Job @username= '".$username."' , @title = '".$title."',  @company= '".$company."', @department= '".$department."'");



 if(empty($result)){
   $_SESSION['error'] = "You cannot either apply for the same job more than once <br> Or apply for a none existant job <br> please wait for the response";
   header("Location: /Database-Project/layout/appology.php");
   exit();
 }else{
   $_SESSION['company']=$company;
   $_SESSION['department']=$department;
   $_SESSION['title']=$title;
   header("Location: /Database-Project/layout/Job Seeker/interviewQuestionsRedirection.php");
   exit();
   /*$_SESSION['accept'] = "You have successfully applied for the job <br> please wait for the response";
   header("Location: /Database-Project/layout/acceptance.php");
   exit();*/
 }

?>
