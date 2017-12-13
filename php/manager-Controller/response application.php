<!DOCTYPE html>
<html>

<head>
    <title>view Application</title>
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
	 $job = post('job');
	 $resp = post('resp');
	 $usn = post('usn');

	 $comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
     $company = "'".($comp[0] -> {'company'})."'" ;
	 $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
     $department = "'".($dep[0] -> {'department'})."'" ;
	 $job_seekers=sqlExec("select js.job_Seekers  from Job_Seeker_apply_Jobs js where
	 js.company=$company and js.department=$department and js.job_Seekers=$usn and js.job=$job  ");
	 if (empty($job_seekers)){
   $_SESSION['error'] = "this Job Seeker did not apply for this job";
   header("Location: /Database-Project/layout/appology.php");
   exit();
 }
	 else{
   $_SESSION['accept'] = "Succesfully reviewed his application";
   header("Location: /Database-Project/layout/acceptance.php");
   exit();
	 }

	 ?>
   <br></br>



</body>

</html>
