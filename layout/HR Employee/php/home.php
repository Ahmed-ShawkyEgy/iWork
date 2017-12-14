

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];

if($request == "open home panel1"){
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
	 echo "<input type='submit' value='View working hours' id='viewWorkingHours' class='formButton'>";
}	 
if($request == "view working hours"){
	$year = post('year');
	$smUsername = post('smUsername');
	$reuslt = sqlExec("exec Total_Number_Hours @HRusername= $username , @SMusername= $smUsername,  @year= $year");
	if(empty($reuslt)){
		echo "No records were found!!";
	}
	else{
		echoTable($reuslt,null);
	}
}
if($request == "view top achievers"){
  $month = post('month'); 
  $reuslt = sqlExec("exec Highest_Achievers @HRusername= $username , @month= $month");
	if(empty($reuslt)){
		echo "No records were found!!";
	}
	else{
		echoTable($reuslt,"top");
	}
}
if($request == "send mail"){
	$staff = post('staff'); 
	$reuslt = sqlExec("exec Send_Email @username= $username,@recipient= $staff,@subject= 'You are a Top Achiver' ,@body= 'you are one of the 3 top achivers yAaAA!!', @out = @o output select @o as 'out';");
	$result = json_decode(json_encode($result), true)[0]['out'];
	if($reuslt == 1){
		echo "Pass";
	}else{
		echo "Error";
	}
}
?>