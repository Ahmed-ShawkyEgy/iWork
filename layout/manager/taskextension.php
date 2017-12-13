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
  <div id="MainStartingImg" class="BigImg">
    <div class="BigImg-wrapper" layout="row" layout-align="center center">
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>
  </br></br></br></br></br>
   <!-- 1 -->


   <div class="container" style="margin-top:100px">




       <div class="row">
           <div class="col-md-2"></div>

           <div class="panel col-md-8">
              <h2>You can view List of tasks with certain projectname and status</h2>
                  <hr><div class = "row announcements">
                          <div class = "col-md-9">
  <form action="\Database-Project\php\manager-Controller\view_task_project_status.php" method="post"  >
        projectname:
		<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
        if(session_status() == PHP_SESSION_NONE)
        session_start();
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='projectname1'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
		Status:
        <select name="status1">
        <option value="Open">Open</option>
        <option value="Closed">Closed</option>
        <option value="Assigned">Assigned</option>
        <option value="Fixed">Fixed</option>
        </select></br></br>
		<input type="submit" class="btn btn-primary"  name="login" value = "view"></br></br>
   </form>

    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>


   <!-- 2 -->

          <div class="row">
              <div class="col-md-2"></div>

              <div class="panel col-md-8">
                 <h2>remove regular employee from project</h2>
                     <hr><div class = "row announcements">
                             <div class = "col-md-9">
   <form action="\Database-Project\php\manager-Controller\remove_regular_employee.php" method="post" >
        projectname:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p2'>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
        Regular_employee:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
		$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
        $company = "'".($comp[0] -> {'company'})."'" ;
	    $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
        $department = "'".($dep[0] -> {'department'})."'" ;
	    $reg_emp=sqlExec("select r.username from Regular_Employees r inner join Staff_Members sm on sm.username=r.username
        where sm.department=$department and sm.company=$company  ");

		echo "<select name='r2'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($reg_emp); $row++){
        foreach ($reg_emp[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
		<input type="submit" class="btn btn-primary"  name="login" value = "submit"></br></br>
   </form>

    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>

    <!-- 3-->

           <div class="row">
               <div class="col-md-2"></div>

               <div class="panel col-md-8">
                  <h2>Assign regular Employee to work on task and he belong to the project</h2>
                      <hr><div class = "row announcements">
                              <div class = "col-md-9">
  <form action="\Database-Project\php\manager-Controller\assign_reg_emp_to_predef_task.php" method="post"  >
        projectname:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p3'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
		Regular_employee:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
		$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
        $company = "'".($comp[0] -> {'company'})."'" ;
	    $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
        $department = "'".($dep[0] -> {'department'})."'" ;
	    $reg_emp=sqlExec("select r.username from Regular_Employees r inner join Staff_Members sm on sm.username=r.username
        where sm.department=$department and sm.company=$company  ");

		echo "<select name='r3'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($reg_emp); $row++){
        foreach ($reg_emp[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
        taskname: <input type="text" name="t3"  required></br></br>
        <input type="submit" class="btn btn-primary"  name="login" value = "Assign"></br></br>
   </form>

    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>

    <!-- 4 -->

           <div class="row">
               <div class="col-md-2"></div>

               <div class="panel col-md-8">
                  <h2>change regular Employee to work on task and he belong to the project</h2>
                      <hr><div class = "row announcements">
                              <div class = "col-md-9">
   <form action="\Database-Project\php\manager-Controller\change_reg_emp_to_assigned_status.php" method="post"  >
        projectname:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p4'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
		Regular_employee:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
		$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
        $company = "'".($comp[0] -> {'company'})."'" ;
	    $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
        $department = "'".($dep[0] -> {'department'})."'" ;
	    $reg_emp=sqlExec("select r.username from Regular_Employees r inner join Staff_Members sm on sm.username=r.username
        where sm.department=$department and sm.company=$company  ");

		echo "<select name='r4'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($reg_emp); $row++){
        foreach ($reg_emp[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
        taskname: <input type="text" name="t4"  required></br></br>
        <input type="submit" class="btn btn-primary"  name="login" value = "Assign"></br></br>
   </form>

    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>

	 <!-- 5 -->

          <div class="row">
              <div class="col-md-2"></div>

              <div class="panel col-md-8">
                 <h2>Review a task that I created in a certain project which has a state ‘Fixed’, and either accept or reject it</h2>
                     <hr><div class = "row announcements">
                             <div class = "col-md-9">
	 <form action="\Database-Project\php\manager-Controller\review_task_certain_status.php" method="post"  >
        projectname:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p5'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
        taskname: <input type="text" name="t5"  required></br></br>
		response:<select name="r5">
         <option value="Accepted">Accepted</option>
         <option value="Rejected">Rejected</option>
         </select></br></br>
		Deadline: <input type="date" name="d5" ></br></br>
	    <input type="submit" class="btn btn-primary"  name="login" value = "Assign"></br></br>

   </form>


    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>

	<!-- 6-->

         <div class="row">
             <div class="col-md-2"></div>

             <div class="panel col-md-8">
                <h2> Assign regular employees to work on any project in my department. Regular employees should be working in the same department</h2>
                    <hr><div class = "row announcements">
                            <div class = "col-md-9">
	 <form action="\Database-Project\php\manager-Controller\assign_reg_to_project.php" method="post"  >
        projectname:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p6'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
        Regular_employee:
		<?php
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
		$comp=sqlExec("select company from Staff_Members where username='".$manager_id."'  ");
        $company = "'".($comp[0] -> {'company'})."'" ;
	    $dep=sqlExec("select department from Staff_Members where username='".$manager_id."'  ");
        $department = "'".($dep[0] -> {'department'})."'" ;
	    $reg_emp=sqlExec("select r.username from Regular_Employees r inner join Staff_Members sm on sm.username=r.username
        where sm.department=$department and sm.company=$company  ");

		echo "<select name='r6'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($reg_emp); $row++){
        foreach ($reg_emp[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<br></br>
	    <input type="submit" class="btn btn-primary"  name="login" value = "Assign"></br></br>

   </form>


    </div>

    </div>

    <br>
    </div>


    <div class="col-md-2"></div>

    </div>


  </div>
  </div>
  </div>

</body>

</html>
