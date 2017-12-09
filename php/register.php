<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
if(session_status() == PHP_SESSION_NONE)
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$personal_email = $_POST['email'];
$birth_date = $_POST['birthDate'];
$years_of_experince = $_POST['yearsOfExperince'];
$first_name = $_POST['firstName'];
$middle_name = $_POST['middleName'];
$last_name = $_POST['lastName'];

//$result = sqlExec("Exec login_user @username= $username , @password = $password");

if ( preg_match('/\s/',$username) ) {
  $_SESSION['error'] = "No spaces are allowed";
  header("Location: /Database-Project/layout/appology.php");
  exit();
}

$result = sqlExec("Exec Register_User @username= '".$username."', @password= '".$password."',@personal_email= '".$personal_email."', @birth_date= '".$birth_date."',@years_of_experince= '".$years_of_experince."',@first_name= '".$first_name."',@middle_name= '".$middle_name."',@last_name= '".$last_name."'");

//echo '2';


 if(empty($result)){
   $_SESSION['error'] = "This username already exits";
   header("Location: /Database-Project/layout/appology.php");
   exit();
 }else{
   /*
   header("Location: /Database-Project/layout/Mainpage.php");
   exit();*/
   $_SESSION['userid'] = $_POST['username'];
   $_SESSION['position'] = (array)sqlExec("Exec Find_Type @username= $username");
   $_SESSION['position'] = json_decode(json_encode(  $_SESSION['position']), true)[0]['tmp'];
   header("Location: /Database-Project/layout/Job Seeker/profile.php");
   exit();
 }

?>
