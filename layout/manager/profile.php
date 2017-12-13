<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>

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
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>
  <div id="MainStartingImg" class="BigImg">
    <div class="BigImg-wrapper" layout="row" layout-align="center center">

</br></br></br></br></br>

       <div class="container" style="margin-top:100px">
           <div class="row">
               <div class="col-md-2"></div>

               <div class="panel col-md-8">
                  <h1> Create Project</h1>
                      <hr><div class = "row announcements">
                              <div class = "col-md-9">
  <form action="/Database-Project/php/manager-Controller/createProject.php" method="post" id="CreateProjectForm">
        <!--username: <input  type="text" name="username" size=40  maxlength="100" placeholder="get up to date DB and delete" required></br></br> -->
        projectname: <input  type="text" name="projectName" placeholder="Project Name" required></br></br>
        startdate: <input type="date" name="startDate" placeholder="Start Date" required></br></br>
        enddate: <input  type="date" name="endDate" placeholder="End Date" required></br></br>
        <input type="submit" class="btn btn-primary"  name="login" value = "Create Project"> </br></br>
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
