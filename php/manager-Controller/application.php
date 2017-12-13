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

  <div class="container" style="margin-top:100px">
      <div class="row">
          <div class="col-md-2"></div>

          <div class="panel col-md-8">
             <h1>Applications</h1>
                 <hr><div class = "row announcements">
                         <div class = "col-md-9">


	 <?php

    require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
     if(session_status() == PHP_SESSION_NONE)
     session_start();
	$manager_id = $_SESSION['userid'];
	//'".$manager_id."'
	$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
	$company = "'".($comp[0] -> {'company'})."'" ;
	$dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
	$department = "'".($dep[0] -> {'department'})."'" ;
	$job=sqlExec("select js.job from Job_Seeker_apply_Jobs js where js.department=$department and js.company=$company ");
	if(empty($job)){
    $_SESSION['error'] = "no records to display";
    header("Location: /Database-Project/layout/appology.php");
    exit();
	}
	else {
	$title = post('title');
	$application=sqlExec("exec Manager_View_Applications_Before_HR @MHRusername='".$manager_id."',@job=$title  ");
  if(empty($application)){
    $_SESSION['error'] = "no records to display";
    header("Location: /Database-Project/layout/appology.php");
    exit();
	}
  else{
	printTableDateTime($application);
  }
}
    ?>



      </div>

      </div>

      <br>
      </div>


      <div class="col-md-2"></div>

      </div>

      </div>

</body>

</html>
