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

	<!-- 6-->
	 <?php
   require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
   if(session_status() == PHP_SESSION_NONE)
   session_start();
         $manager_id = $_SESSION['userid'];
         //'".$manager_id."'
		 $p6 = post('p6');
		 $r6 = post('r6');

         $reg_to_project=sqlExec("exec Assign_Regular_To_Project
         @MHRusername='".$manager_id."', @titleOfProject=$p6 , @username=$r6 ");

		if(empty($reg_to_project)){
    $_SESSION['error'] = "you cannot insert same employee into more than 2 projects";
    header("Location: /Database-Project/layout/appology.php");
    exit();


  }
		else{
    $_SESSION['accept'] = "Assigned to project succesful";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();


   }


     ?>

	</body>

</html>
