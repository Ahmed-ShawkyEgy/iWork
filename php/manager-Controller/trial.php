


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
  <div id="MainStartingImg" class="BigImg">
    <div class="BigImg-wrapper" layout="row" layout-align="center center">
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?></br></br></br></br></br>
  <div class="container" style="margin-top:100px">
      <div class="row">
          <div class="col-md-2"></div>

          <div class="panel col-md-8">
             <h1> Print Table</h1>
                 <hr><div class = "row announcements">
                         <div class = "col-md-9">
    <form action="/Database-Project/php/manager-Controller/trialcontinue.php" method="post" >
        startdate: <input type="date" name="startDate" placeholder="Start Date"></br></br>
        <?php
		 require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
        if(session_status() == PHP_SESSION_NONE)
        session_start();
        $manager_id = $_SESSION['userid'];
        //'".$manager_id."'
	    $nameofproject=sqlExec("exec get_project_name @Manager='".$manager_id."' ");
        echo "<select name='p2'>";
		echo "<option value='default'>default</option>";
        for($row = 0; $row < count($nameofproject); $row++){
        foreach ($nameofproject[$row] as $key => $value){
        echo "<option value='".$value."'>".$value."</option>";
		}
	    }
        echo "</select>";
		?>
		<input type="submit" class="btn btn-primary"  name="login" value = "Create Project"></br></br>
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
