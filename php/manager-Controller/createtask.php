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
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?></br></br></br></br></br>

  <form action="/Database-Project/php/manager-Controller/createtask.php" method="post" >
        <!--username: <input  type="text" name="username" placeholder="get up to date DB and delete" required></br></br> -->
        projectname:
	    <?php
	     require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
        if(session_status() == PHP_SESSION_NONE)
        session_start();
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='projectName'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
        ?>
        <br></br>
        taskname: <input type="text" name="taskname" placeholder="name of task" required></br></br>
        deadline: <input  type="date" name="deadline" placeholder="deadline of task" required></br></br>
		description:</br><textarea rows="4" cols="50" name="description" form="createTask" style="margin: 0px; width: 611px; height: 122px;" required></textarea></br></br>
        <input type="submit" name="login" value = "Create Task"></br></br>
   </form>

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

$check = sqlExec("select t.name from Tasks t
where t.name=$taskname and t.project=$projectName and t.company=$company");

if(empty($check)){
    echo "you cannot insert deadline of task after project deadline or before project deadline";
}
else
  echo "created Task succesfull";
}
else{
  echo "this taskname already exists and choose another one";
}

?>

  

</body>

</html>
