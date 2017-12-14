

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];

if($request == "open attendance"){
	$HRInfo = sqlExec("select department,company from Staff_Members where username= $username");
	$HRCompany = "'".($HRInfo[0] -> {'company'})."'";
	$HRDepartment = "'".($HRInfo[0] -> {'department'})."'";
	$reuslt = sqlExec("select username from Staff_Members where department= $HRDepartment and company= $HRCompany and username <> $username");
	 echo "</br><select name='staffMembersSelection' id='staffMembersSelection' class='formInput'>";
     for($row = 0; $row < count($reuslt); $row++)
	 {
     foreach ($reuslt[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		 }
	 }

     echo "</select>";
	 echo "<input type='submit' value='View Attendance' id='viewAttendanceButton' class='formButton'>";
}	 
if($request == "view attendance"){
	$startDate = post('start_date');
	$endDate = post('end_date');
	$smUsername = post('SMusername');
	$reuslt = sqlExec("exec Total_Number_Hours @HRusername= $username, @SMusername= $smUsername,  @year int");
	if(empty($reuslt)){
		echo "No records were found!!";
	}
	else{
		echoTable($reuslt,null);
	}
}
?>