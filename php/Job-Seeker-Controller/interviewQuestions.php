<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
//name='Option".$row."'
//$_SESSION['modelAnswer'][$row]
//  $searchQuery =  post('searchText');

$username = $_SESSION['userid'];
$title =  $_SESSION['title'];
$company =  $_SESSION['company'];
$department =  $_SESSION['department'];
$modelAnswer= $_SESSION['modelAnswer'];
$searchQuery= array();
for($row = 0; $row < count($modelAnswer);$row++){
  array_push($searchQuery,$_POST["Option".$row]);
}
$countT=0;
for($row = 0; $row < count($modelAnswer)&& $row < count($searchQuery);$row++){

if($modelAnswer[$row]==$searchQuery[$row]){
  $countT++;
}
}
//Save_Score

$result = sqlExec("Exec Save_Score @username= '".$username."' , @title = '".$title."',  @company= '".$company."', @departement= '".$department."', @score= '".$countT."'");

$_SESSION['accept'] = "You have successfully applied for the job <br> Your score is ".$countT."/".count($_SESSION['modelAnswer'])." <br> please wait for the response";
header("Location: /Database-Project/layout/acceptance.php");
exit();


?>
