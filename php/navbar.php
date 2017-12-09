<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");

if(session_status() == PHP_SESSION_NONE){
  session_start();
}
echo '<div id="navigation" class="col-xs-12">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div id="ShortcutLinks">
        <a href="/Database-Project/layout/MainPage.php" class="navbar-brand">iWork</a>';
        if ($_SESSION['userid'] == null)
        echo '<a href="/Database-Project/php/MainUserInterface.php" class="navbar-brand">Profile</a>';
if ($_SESSION['userid'] != null) {
    echo '<a href="/Database-Project/php/logout.php" class="navbar-brand" style="position: absolute;right: 0px;  z-index: 100;">Logout</a>';
    echo   '<a href="/Database-Project/php/MainUserInterface.php" class="navbar-brand" style="  position: absolute;right: 68px;z-index: 100;">'.$_SESSION['userid'].'</a>';
}
echo   "</div>
    </div>
  </nav>
</div>";
