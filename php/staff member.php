<?php
session_start();
echo $_SESSION['userid'];
if($_SESSION==null or $_SESSION['type']!='staff member')
{
   header("Location: /layout/Appology/user-appology.html");
   exit();
}
?>
