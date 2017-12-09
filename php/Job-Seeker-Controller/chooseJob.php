<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();

$_SESSION['title']=$_POST['job'];
$_SESSION['company']=$_POST['company'];
$_SESSION['department']= $_POST['department'];

header("Location: /Database-Project/layout/Job Seeker/enterChooseJobsSelectedRedirection.php");
exit();
/*
$username = $_SESSION['userid'];
$job= post('job');
$department= post('department');
$company= post('company');
$dayoff=post('dayoff');
$managerType=post('$managerType')
//@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255), @dayoff varchar(255), @managerType varchar(255)=null

if (strpos($job, 'Manager') == true) {
  $result = sqlExec("Exec Select_Job @username= '".$username."' , @title = $job,  @company= $company, @departement= $department, @dayoff=$dayoff,@managerType=$managerType");
}else
  $result = sqlExec("Exec Select_Job @username= '".$username."' , @title = $job,  @company= $company, @departement= $department, @dayoff=$dayoff");

$_SESSION['accept'] = "You have successfully selected a job <br> Welcome To The Family";
header("Location: /Database-Project/layout/acceptance.php");
exit();
*/
?>
