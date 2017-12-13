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
         //'".$manager_id."'
		 $projectname1 = post('projectname1');
         $status1 = post('status1');
         $task_of_project=sqlExec("exec View_Tasks_Manager_With_Certain_Conditions @MHRusername='".$manager_id."',
		 @project_name=$projectname1,@status=$status1 ");
         if(empty($task_of_project)){
		 echo "no records to display";}
         else {
         printTableDateTime($task_of_project);}
         ?>

</body>

</html>
