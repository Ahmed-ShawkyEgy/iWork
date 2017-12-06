<?php
$serverName = "LAPTOP-NOI8J1AD\sqlexpress";
$connectionInfo = array( "Database"=>"mileStone 3");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if($conn) {
     echo "Database connection established.<br />";
}else{
     echo "Database connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>
