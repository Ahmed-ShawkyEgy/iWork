<?php
require("../helper/sqlExec.php");
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$personal_email = $_POST['email'];
$birth_date = $_POST['birthDate'];
$years_of_experince = $_POST['yearsOfExperince'];
$first_name = $_POST['firstName'];
$middle_name = $_POST['middleName'];
$last_name = $_POST['lastName'];
echo '1';

//$result = sqlExec("Exec login_user @username= $username , @password = $password");
$result = sqlExec("Exec Register_User  @username= $username, @password= $password,@personal_email= $personal_email, @birth_date= $birth_date ,@years_of_experince= $years_of_experince,@first_name= $first_name,@middle_name= $middle_name,@last_name= $last_name")[0];
echo '2';
 if(empty($result)){
   echo "FUCK YOU!!!!!! Fuck OFFF!!";
 }else{
   $_SESSION['userid'] = $_POST['username'];
   $_SESSION['position'] = sqlExec("Exec Find_Type @username= $username")[0][0];
   header("Location: /Database-Project/layout/mainlayout.html");
   exit();
 }

?>
