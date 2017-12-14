<!DOCTYPE html>
<html>

<head>
    <title>create task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link rel="stylesheet" href="/Database-Project/style/manager.css">
</head>

<body>
  <div id="MainStartingImg" class="BigImg">
    <div class="BigImg-wrapper" layout="row" layout-align="center center">
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?></br></br></br></br></br>


 <?php

$manager_id = $_SESSION['userid'];
//'".$manager_id."'
//$username = "'".$_SESSION['userid']."'" ; // remove comment when you update your DB

//$username = post('username');
$projectName = post('projectName');
$taskname = post('taskname');
$deadline = post('deadline');
$description = post('description');

$comp=sqlExec("select company from Staff_Members where username='".$manager_id."' ");
//print_r($dep);
$company = "'".($comp[0] -> {'company'})."'" ;
$checkForExistance = sqlExec("select t.name from Tasks t where t.name=$taskname and t.project=$projectName and t.company=$company");

if(empty($checkForExistance)){
	$result = sqlExec(" exec Create_Task_Manager
	@MHRusername='".$manager_id."', @taskName=$taskname,@project_name=$projectName,
	@deadline=$deadline, @status='Open',
	@description=$description" );

	if(empty($result)){
	$_SESSION['error'] = "you cannot insert deadline of task after project deadline or before project deadline";
	header("Location: /Database-Project/layout/appology.php");
	exit();}

	else{
	$_SESSION['accept'] = "created task succesful";
	header("Location: /Database-Project/layout/acceptance.php");
	exit();}
}

else{
  $_SESSION['error'] = "this taskname already exists and choose another one";
  header("Location: /Database-Project/layout/appology.php");
  exit();
}

?>


</div></div>
</body>

</html>
