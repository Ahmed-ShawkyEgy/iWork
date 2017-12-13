<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo '<div id="navigation" class="col-xs-12">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div id="ShortcutLinks">
        <a href="/Database-Project/layout/MainPage.php" class="navbar-brand">iWork</a>';
        if (!array_key_exists('userid', $_SESSION) || $_SESSION['userid'] == null) {
            echo '<a href="/Database-Project/php/MainUserInterface.php" style="position: absolute;right: 0px;  z-index: 100;" class="navbar-brand">Login</a>';
        }
if (array_key_exists('userid', $_SESSION) && $_SESSION['userid'] != null &&$_SESSION['position']!='job_seeker') {
    echo '<a href="/Database-Project/php/logout.php" class="navbar-brand" style="position: absolute;right: 0px;  z-index: 100;">Logout</a>';
      echo   '<a href="/Database-Project/layout/Staff Member/profile.php" class="navbar-brand" style="  position: absolute;right: 68px;z-index: 100;">Options</a>';
    echo   '<a href="/Database-Project/php/MainUserInterface.php" class="navbar-brand" style="  position: absolute;right: 145px;z-index: 100;">'.$_SESSION['userid'].'</a>';
}
else{
  if(array_key_exists('userid', $_SESSION) && $_SESSION['userid'] != null){
    echo '<a href="/Database-Project/php/logout.php" class="navbar-brand" style="position: absolute;right: 0px;  z-index: 100;">Logout</a>';
    echo   '<a href="/Database-Project/php/MainUserInterface.php" class="navbar-brand" style="   position: absolute;right: 68px;z-index: 100;">'.$_SESSION['userid'].'</a>';
  }
}
echo   "</div>
    </div>
  </nav>
</div>";
