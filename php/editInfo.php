<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
$username=$_SESSION['userid'];
$password = $_POST['password'];
$birthDate=$_POST['birthDate'];
$email = $_POST['email'];
$yearsOfExperince = $_POST['yearsOfExperince'];
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
/*
foreach ($_POST as $name => $value) {
   echo $name;
    print ('//');
   echo $value;
   print ('<br>');
}*/
if($password!= '')
 sqlExec("Exec edit_user_info @username='".$username."', @password='".$password."'");
 if($email!= '')
  sqlExec("Exec edit_user_info @username='".$username."', @personal_email='".$email."'");
  if($birthDate!= '')
   sqlExec("Exec edit_user_info @username='".$username."', @birth_date='".$birthDate."'");
   if($yearsOfExperince!= '')
    sqlExec("Exec edit_user_info @username='".$username."', @years_of_experince='".$yearsOfExperince."'");
    if($firstName!= '')
     sqlExec("Exec edit_user_info @username='".$username."', @first_name='".$firstName."'");
     if($middleName!= '')
      sqlExec("Exec edit_user_info @username='".$username."',  @middle_name='".$middleName."'");
      if($lastName!= '')
       sqlExec("Exec edit_user_info @username='".$username."', @last_name='".$lastName."'");

       $_SESSION['accept'] = "You have successfully edited your info";
       header("Location: /Database-Project/layout/acceptance.php");

?>
