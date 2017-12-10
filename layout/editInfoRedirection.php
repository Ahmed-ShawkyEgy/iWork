<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="/Database-Project/style/editPage.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<script src="jquery-3.2.1.min.js"></script>
<script src="script.js"></script>
</head>

<body>
  <div id = "mainPanel" class = "square">
  <div id = "errorPanel" class = "square">
  </div>
<div id="Main" class="container-fluid">

  <div id="RowStarter" class="row">
      <?php require($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>
    <div id="MainStartingImgBlock">
    <div id="MainStartingImg" class="BigImg">
      <div class="BigImg-wrapper" layout="row" layout-align="center center">
        <div id="FontAwesomeIconsTopImg">

  <a href="#"><img class="smaller-image thick-green-border" src="http://sguru.org/wp-content/uploads/2017/06/cool-profile-pictures-8DtpgWJB_400x400.jpeg" alt="A cute orange cat lying on its back. "></a>
  </br>  </br>
  <form action="/Database-Project/php/editInfo.php" method="post">
          <input  style="width: 400px;"  type="password" name="password" placeholder="Password">
        </br>
          <input  style="width: 400px;"  type="email" name="email" placeholder="Personal Email">
          </br>
          <input  style="width: 400px;"  type="date" name="birthDate" placeholder="Birth date">
            </br>
          <input  style="width: 400px;"  type="number" name="yearsOfExperince" placeholder="Years of experince">
              </br>
          <input  style="width: 400px;"  type="text" name="firstName" placeholder="First name">
                </br>
          <input  style="width: 400px;"  type="text" name="middleName" placeholder="Middle name">
                  </br>
          <input  style="width: 400px;"  type="text" name="lastName" placeholder="Last name">
    </br>  </br>
        <div  class="col-xs-12">
        <input class="btn btn-primary "type="submit" name="login" style="width: 400px;" value = "Edit">
        </form>
      </div>
          </div>
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
</div>
</body>
</html>
