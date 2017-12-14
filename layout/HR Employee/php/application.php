

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];
$title = post('title');
if($request == "view application"){
	$result = sqlExec(" exec View_New_Application @HRusername= $username,@title= $title ");
	if(empty($result)){
		echo "No records were found!!";;
	}else{
		echoTable($result,"ar");
	}
}
if($request == "AR application"){
	$applicantUsername = post('applicantUsername');
	$response = post('response');
	$result = sqlExec("exec Accept_Or_Reject @HRusername= $username,@ApplicantUsername= $applicantUsername ,@title= $title,@response= $response");
	$result = sqlExec("select hr_response from Job_Seeker_apply_Jobs where job_Seekers = $applicantUsername and job = $title");
	if($result[0]->{'hr_response'} == "Pending"){
		echo "Error: job seeker can not be a staff member";
	}else{
	    echo "Pass: job seeker is now a staff member";
	}
}
?>