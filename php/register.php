<?php

require("../connection/databaseConnection.php");

$myparams['username'] = $_POST['username'];
$myparams['password'] = $_POST['password'];
$myparams['personal_email'] = $_POST['email'];
$myparams['birth_date'] = $_POST['birthDate'];
$myparams['years_of_experince'] = $_POST['yearsOfExperince'];
$myparams['first_name'] = $_POST['firstName'];
$myparams['middle_name'] = $_POST['middleName'];
$myparams['last_name'] = $_POST['lastName'];

$procedure_params = array(
  array(&$myparams['username'], SQLSRV_PARAM_OUT),
  array(&$myparams['password'], SQLSRV_PARAM_OUT),
  array(&$myparams['personal_email'], SQLSRV_PARAM_OUT),
  array(&$myparams['birth_date'], SQLSRV_PARAM_OUT),
  array(&$myparams['years_of_experince'], SQLSRV_PARAM_OUT),
  array(&$myparams['first_name'], SQLSRV_PARAM_OUT),
  array(&$myparams['middle_name'], SQLSRV_PARAM_OUT),
  array(&$myparams['last_name'], SQLSRV_PARAM_OUT)
);
 
 
 $sql = "Exec Register_User  @username= ?, @password= ?,@personal_email= ?, @birth_date= ? ,@years_of_experince= ?,@first_name= ?,@middle_name= ?,@last_name= ?";

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