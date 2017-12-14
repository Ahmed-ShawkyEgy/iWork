

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];
if($request == "view request"){
	$requestType = $_POST['requestType'];
	$result = sqlExec("exec View_Requests @HRusername= $username");
	for($i = 0; $i < count($result); $i++){
		$applicant = "'".($result[$i] -> {'applicant'})."'";
		$start_date = "'".($result[$i] -> {'start_date'} ->format("Y-m-d"))."'";
	  if($requestType == "leave"){
		  $check = sqlExec("select * from Leave_Requests where start_date= $start_date and applicant= $applicant");
	  }
	  else if($requestType == "business"){
		  $check = sqlExec("select * from Business_Trip_Requests where start_date= $start_date and applicant= $applicant");
	  }
	  if(empty($check))
		  unset($result[$i]);
	}
	if(empty($result)){
		echo "No records were found!!";;
	}else{
		echoTable($result,"ar");
	}
}
if($request == "AR request"){
	$applicantUsername = post('applicantUsername');
	$response = post('response');
	$start_date = post('start_date');
	$result = sqlExec("exec Accept_Or_Reject_Manager_Accepted @HRusername= $username , @response= $response, @applicant= $applicantUsername, @start_date= $start_date");
	$result = sqlExec("select hr_response from Requests where start_date = $start_date and applicant = $applicantUsername");
	if($result[0]->{'hr_response'} == "Pending"){
		echo "Error: job seeker can not be a staff member";
	}else{
	    echo "Pass: job seeker is now a staff member";
	}
}
?>