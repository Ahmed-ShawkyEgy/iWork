<!DOCTYPE html>
<html>

<head>
    <title>view specific task</title>
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
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?></br></br></br></br></br>

	<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
  if(session_status() == PHP_SESSION_NONE)
  session_start();
	$manager_id = $_SESSION['userid'];
	$p3 = post('p3');
    $t3 = post('t3');
	$r3 = post('r3');
	$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
    $company = "'".($comp[0] -> {'company'})."'" ;
	$taskname_exists=sqlExec("select t.name from tasks t where t.name=$t3 and t.project=$p3 and t.company=$company and
    t.manager='".$manager_id."' and t.status='Open'	");
	$reg_exists_project=sqlExec("select * from Managers_assign_Regular_Employees_Projects where project_name=$p3
    and regular_employee=$r3 and company=$company ");
	if (empty($taskname_exists)){
	echo "this taskname doesnot exits in this project or you cannot assign regular_employee into unless task Status is Open";}
	else{
	if(empty($reg_exists_project)){
	echo "this reqular employee is not assigned to the project" ;}
	else{
	     $astm=sqlExec("exec Assign_Regular_Task_Manager
         @MHRusername='".$manager_id."', @regular_employee=$r3,
         @project_name=$p3,@taskName=$t3 ");
	     echo "assigned to task  succesfully" ;

	}
    }

	?>


</body>

</html>
