<?php

require("../helper/sqlExec.php");
session_start();
$searchQuery =  post('searchText');
$searchOption = $_POST['searchOption'];
if($searchOption == "Name")
   $result = sqlExec("Exec search @name=$searchQuery");
else if($searchOption == "Type")
   $result = sqlExec("Exec search @type=$searchQuery");
else if($searchOption == "Address")
   $result = sqlExec("Exec search @address=$searchQuery");

if(empty($result))
 echo "I LOVE YOU <3";
else
 printTable($result);
 //print_r($result);

?>
