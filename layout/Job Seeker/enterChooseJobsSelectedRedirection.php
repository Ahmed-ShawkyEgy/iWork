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
  <link rel="stylesheet" href="/Database-Project/style/enterChooseJobsSelected.css">
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
          <div layout="column" >

              <a href="#"><img class="smaller-image thick-green-border" src="http://sguru.org/wp-content/uploads/2017/06/cool-profile-pictures-8DtpgWJB_400x400.jpeg" alt="A cute orange cat lying on its back. "></a>
              </br>  </br>
            <h1 class="md-display-2"></h1>
            <form action="/Database-Project/php/Job-Seeker-Controller/enterChooseJobsSelected.php" method="post">

              <select name="searchOption">
                 <option value="dayoff">Dayoff</option>
                 <option value="Saturday">Saturday</option>
                 <option value="Sunday">Sunday</option>
                 <option value="Monday">Monday</option>
                 <option value="Tuesday">Tuesday</option>
                 <option value="Wednesday">Wednesday</option>
                 <option value="Thursday">Thursday</option>
             </select>
             <?php
             require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
             if(session_status() == PHP_SESSION_NONE)
              session_start();
             if (strpos($_SESSION['title'], 'Manager') !== false){
               print ('Hello');
               echo "<input  style='width: 400px;'  type='text' placeholder='Enter Type' name ='ManagerType' required>";
             }
             ?>
             <input class="btn btn-primary "type="submit" name="searchButton"  value = "Submit">
           </form>
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

          <div id="FooterText"><ul id="ulLinkList"><li>Copyrights &copy; H. Morgan 2017. This page was created for educational purposes only as a project for GUC.</li></ul>
          </div>
        </footer>
      </div>
    </div>
  </div>


</body>

</html>
