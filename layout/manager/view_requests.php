<!DOCTYPE html>
<html>

<head>
    <title>view Requests</title>
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
             <h1> Requests</h1>
                 <hr><div class = "row announcements">
                         <div class = "col-md-9">
      <?php
       require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
      if(session_status() == PHP_SESSION_NONE)
      session_start();

     $manager_id = $_SESSION['userid'];
     //'".$manager_id."'
     $table_of_requests=sqlExec("exec Final_Accept_Request @MHRusername='".$manager_id."' ");
     if(empty($table_of_requests)){
     echo "no records to display";
     }
     else {
     printTableDateTime($table_of_requests);}
     ?>

 </div>

 </div>

<br>
 </div>


 <div class="col-md-2"></div>

 </div>

 <div class="row">
     <div class="col-md-2"></div>

     <div class="panel col-md-8">
        <h1> Accept or Reject Requests</h1>
            <hr><div class = "row announcements">
                    <div class = "col-md-9">
	 <form action="\Database-Project\php\manager-Controller\requests.php" method="post" id="reason"  >
        response:
		<select name="resp">
        <option value="Accepted">Accepted</option>
        <option value="Rejected">Rejected</option>
        </select></br></br>
		Start date: <input type="date" name="startDate" required></br></br>

		Staff_memeber:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
        $company = "'".($comp[0] -> {'company'})."'" ;
	    $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
        $department = "'".($dep[0] -> {'department'})."'" ;		
		$username_of_staffmemebers=sqlExec("select distinct r.applicant from Requests r inner join Staff_Members sm on sm.username=r.applicant
        where sm.company=$company and sm.department=$department and r.applicant<>'".$manager_id."' 
		and not exists (select m.username from Managers m where m.username=r.applicant) ");
		
        echo "<select name='sm'>";
		echo "<option value='choosestaff'>choose Staff member</option>";
        for($row = 0; $row < count($username_of_staffmemebers); $row++){
        foreach ($username_of_staffmemebers[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
		reason:</br><textarea rows="4" cols="50" name="rs" form="reason" style="margin: 0px; width: 611px; height: 122px;" ></textarea></br></br>
        <input type="submit" class="btn btn-primary"  name="login" value = "accept/reject"></br></br>
   </form>


 </div>

 </div>

<br>
 </div>


 <div class="col-md-2"></div>

 </div>

</div>
</div></div>

</body>

</html>
