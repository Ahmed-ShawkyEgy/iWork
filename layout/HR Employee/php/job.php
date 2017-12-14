

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];

if($request == "create job"){
$title = post('title');
$short_desctiption = post('short_description');
$min_experience = post('min_experience');
$salary = post('salary');
$deadline = post('deadline');
$no_of_vacancies = post('no_of_vacancies');
$working_hours = post('working_hours');
$detailed_description = post('detailed_description');
$result = sqlExec("select title from Jobs where title = $title");
if(empty($result)){
	$result = sqlExec("exec Creating_Job @HRusername = $username,@title = $title, @short_description = $short_desctiption,@detailed_description= $detailed_description, @min_experience= $min_experience,@salary= $salary ,@deadline= $deadline , @no_of_vacancies= $no_of_vacancies,@working_hours=$working_hours");
    $result = sqlExec("select title from Jobs where title = $title");

   if(empty($result)){
	 echo "Error: Failed to create job";
   }
   else{
	echo "Pass: Job was created";
   }
}
else{
	echo "Error: Already exists";
}
}

else if($request == "search job"){
$title = post('title');
   $result = sqlExec(" exec View_Info @HRusername= $username ,@title= $title");
    if(empty($result)){
	 echo "No records were found!!";
   }
   else{
	 echoTable($result,null);
   }
}

else if($request == "edit job"){
$title = post('title');
$short_desctiption = post('short_description');
$min_experience = post('min_experience');
$salary = post('salary');
$deadline = post('deadline');
$no_of_vacancies = post('no_of_vacancies');
$working_hours = post('working_hours');
$detailed_description = post('detailed_description');
$result = sqlExec("select title from Jobs where title = $title");
if(!(empty($result))){
	$result = sqlExec("exec Edit_Info @HRusername = $username,@title = $title, @short_description = $short_desctiption,@detailed_description= $detailed_description, @min_experience= $min_experience,@salary= $salary ,@deadline= $deadline , @no_of_vacancies= $no_of_vacancies,@working_hours=$working_hours");
    $result = sqlExec("select title from Jobs where title = $title");

   if(empty($result)){
	 echo "Error: Failed to edit job";
   }
   else{
	 echo "Pass: Job was editted";
   }
}
else{
	echo "Error: no record already exists to edit";
}
}
?>