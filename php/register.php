<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
//$username = $_POST['username'];
//$password = $_POST['password'];
//$personal_email = $_POST['email'];
//$birth_date = $_POST['birthDate'];
//$years_of_experince = $_POST['yearsOfExperince'];
//$first_name = $_POST['firstName'];
//$middle_name = $_POST['middleName'];
//$last_name = $_POST['lastName'];

$username = 'assaaa';
$password = '123';
$personal_email = 'aw@awf.com';
$birth_date = '1997-07-28';
$years_of_experince = 3;
$first_name = 'Aa';
$middle_name = 'awfwa';
$last_name = 'awgwagweg';
//$result = sqlExec("Exec login_user @username= $username , @password = $password");
echo $username."<br>";
echo $password."<br>";
echo $personal_email."<br>";
echo $birth_date."<br>";
echo $years_of_experince."<br>";
echo $first_name."<br>";
echo $middle_name."<br>";
echo $last_name."<br>";

$result = sqlExec("Exec Register_User @username= ".$username.", @password= ".$password.",@personal_email= '".$personal_email."', @birth_date= '".$birth_date."',@years_of_experince= ".$years_of_experince.",@first_name= ".$first_name.",@middle_name= ".$middle_name.",@last_name= ".$last_name."");

echo '2';


 if(empty($result)){
   echo "FUCK YOU!!!!!! Fuck OFFF!!";
 }else{
   header("Location: /Database-Project/layout/Mainpage.html");
   exit();
 }

?>
