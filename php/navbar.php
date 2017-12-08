<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");

if(session_status() == PHP_SESSION_NONE)
    session_start();

echo '<div id="navigation" class="col-xs-12">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div id="ShortcutLinks">
                    <a href="/Database-Project/layout/Mainpage.php" class="navbar-brand">iWork</a>
                        <a href="/Database-Project/layout/Staff%20Member/profile.php" class="navbar-brand">Profile</a>';


if(array_key_exists ('userid',$_SESSION))
{ 
    echo '<a href= "/Database-Project/php/logout.php" class="navbar-brand">Logout</a>';
}
   
echo   "</div>
    </div>
  </nav>
</div>";
 ?>
