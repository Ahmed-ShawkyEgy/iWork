
<?php
$serverName = "ME-PC\sqlexpress";
$connectionInfo = array( "Database"=>"IWorkDB");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>