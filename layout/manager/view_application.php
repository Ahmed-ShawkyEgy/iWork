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
  <div id="MainStartingImg" class="BigImg">
    <div class="BigImg-wrapper" layout="row" layout-align="center center">
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?></br></br></br></br></br>


     <div class="container" style="margin-top:100px">
         <div class="row">
             <div class="col-md-2"></div>

             <div class="panel col-md-8">
                <h1> view Applications of Specific Job</h1>
                    <hr><div class = "row announcements">
                            <div class = "col-md-9">
     <form action="\Database-Project\php\manager-Controller\application.php" method="post" >
	 job:
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
	 $job=sqlExec("select distinct js.job from Job_Seeker_apply_Jobs js where js.department=$department and js.company=$company ");
     //$_POST['Managers']

	 echo "<select name='title'>";
	 echo "<option value='choosejob'>choose Job</option>";
     for($row = 0; $row < count($job); $row++)
	 {
     foreach ($job[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		 }
	 }

     echo "</select>";

	 ?>

	 </br></br>
	 <input type="submit" class="btn btn-primary" name="view_app" value="view applications needed to be handled"  />

	 </form>
 </div>

 </div>

<br>
 </div>


 <div class="col-md-2"></div>

 </div>



 <div class="row">
     <div class="col-md-2"></div>

     <div class="panel col-md-8">
<h1> Accept or Reject Applications </h1>
            <hr><div class = "row announcements">
                    <div class = "col-md-9">

		 <form action="\Database-Project\php\manager-Controller\response application.php" method="post">
	 Job:
	 <?php
	 $manager_id = $_SESSION['userid'];
     //'".$manager_id."'
	 $comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
     $company = "'".($comp[0] -> {'company'})."'" ;
	 $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
     $department = "'".($dep[0] -> {'department'})."'" ;
	 $job=sqlExec("select distinct js.job from Job_Seeker_apply_Jobs js
	 where js.company=$company and js.department=$department and js.hr_response='Accepted' ");
        echo "<select name='job'>";
		echo "<option value='choosejob'>choose Job</option>";
        for($row = 0; $row < count($job); $row++){
        foreach ($job[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
	 ?>
	 <br></br>
	 response:<select name="resp">
         <option value="Accepted">Accepted</option>
         <option value="Rejected">Rejected</option>
         </select></br></br>
	 username:
	 <?php
	 $manager_id = $_SESSION['userid'];
     //'".$manager_id."'
	 $comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
     $company = "'".($comp[0] -> {'company'})."'" ;
	 $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
     $department = "'".($dep[0] -> {'department'})."'" ;
	 $job_seekers=sqlExec("select distinct js.job_Seekers  from Job_Seeker_apply_Jobs js
	 where js.company=$company and js.department=$department and js.hr_response='Accepted' ");
        echo "<select name='usn'>";
		echo "<option value='chooseusn'>choose any job_seeker</option>";
        for($row = 0; $row < count($job_seekers); $row++){
        foreach ($job_seekers[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
	 ?>
	 	 <br></br>

	 		<input type="submit" class="btn btn-primary"  name="option" value="accept/reject" /></br></br>

      </form></br>

       </div>

       </div>

      <br>
       </div>


       <div class="col-md-2"></div>

       </div>
     </div></div>

</div>
</body>

</html>
