<?php


require("../connection/databaseConnection.php");

$myparams['username'] = $_POST['username'];
$myparams['password'] = $_POST['password'];

$procedure_params = array(
  array(&$myparams['username'], SQLSRV_PARAM_OUT),
  array(&$myparams['password'], SQLSRV_PARAM_OUT)
);
 
 
 $sql = "Exec login_user @username = ? , @password = ?";

 $stmt = sqlsrv_prepare($conn, $sql, $procedure_params);
 
 if( !$stmt ) {
   die( print_r( sqlsrv_errors(), true));
}
else{
	$_SESSION['userid'] = $_POST['username'];
	header("Location: /layout/mainlayout.html");
	exit();
}



 
?>