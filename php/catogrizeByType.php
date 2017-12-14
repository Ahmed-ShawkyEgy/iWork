<!DOCTYPE html>
<html>

<head>
  <!-- require_onced meta tags always come first -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
  <link rel="stylesheet" href="css/custom.css">
  <!-- Add icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../style/catogrizeByType.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body>
  <div id="Main" class="container-fluid">

    <div id="RowStarter" class="row">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>
      <div id="MainStartingImgBlock">
      <div id="MainStartingImg" class="BigImg">
        <div class="BigImg-wrapper" layout="row" layout-align="center center">
          <div layout="column">
            <h1 class="md-display-2"><?php

            require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
            if(session_status() == PHP_SESSION_NONE)
            session_start();

               $_SESSION['result'] = sqlExec("Exec View_All_Companies_Type");

            if(empty( $_SESSION['result'])){
            $_SESSION['error'] = "An error occured";
            header("Location: /Database-Project/layout/appology.php");
            exit();
          }else
             printTableLinksType( $_SESSION['result']);
             //print_r($result);

            ?></h1>
            </div>
              <div id='stretch'></div>
          </div>
          </div>
         </div>
         </div>
      </div>

      <div id="footer" >
        <footer class="col-md-12">
          <div id="LinksInPageShortcuts">
              <ul id="ulLinkList">
              <li><a href="#">Home</a></li>
              <li><a href="#AboutBlock">About</a></li>
              <li><a href="#ContactBlock">Contacts</a></li>
              </ul>
          </div>

          <div id="FooterText"><ul id="ulLinkList"><li>Copyrights &copy; Team XIII 2017. This page was created for educational purposes only as a project for GUC.</li></ul>
          </div>
        </footer>
      </div>
    </div>
  </div>


</body>

</html>
