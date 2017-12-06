<?php
require("../helper/sqlExec.php");
session_start();

//$username = 'Soldier';
//$password = 'first';
//$result = sqlExec("Exec login_user @username= $username , @password = $password");
$_SESSION['userid'] = 'Soldier';
//print($_SESSION["userid"]);
//print("</br>");
$result2 = sqlExec("SELECT  * FROM Users WHERE username = '".$_SESSION['userid']."'");
print_r($result2);
//header("Location: /php/staff member.php");
//exit();/// exit whatever data
?>
