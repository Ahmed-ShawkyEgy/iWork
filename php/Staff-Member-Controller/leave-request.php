<?php
// Staff Member Apply for request
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
if (session_status() == PHP_SESSION_NONE)
    session_start();



$start_date = $_POST['startDate'];
$end_date = $_POST['endDate'];
$type = $_POST['type'];
$usernameReplacement = $_POST['replacement'];


switch($type)
{
    case 'Sick Leave'        : $type = 'sick_leave'; break;
    case 'Accidential Leave' : $type = 'accidential_leave';break;
    case 'Annual Leave'      : $type = 'annual_leave';break;
}

$result = (array)sqlExec("declare @x int
exec Apply_Request @username= '".$_SESSION['userid']."',@start_date='".$start_date."', @end_date='".$end_date."' ,@type = '".$type."', @usernameReplacement='".$usernameReplacement."' , @out = @x output
select @x as 'out'");


$result = json_decode(json_encode($result), true)[0]['out'];

if ($result == 1) {
    // Success !
    $_SESSION['accept'] = "Request applied succesfully";
    header("Location: /Database-Project/layout/acceptance.php");
    exit();
} else if($result == 2){
     $_SESSION['error'] = "Failed to apply<br>Please make sure that your replacement's username is a valid one";
    header("Location: /Database-Project/layout/appology.php");
    exit();
    
}
else if($result == 3)
{
     $_SESSION['error'] = "Failed to apply<br>Please make sure that the duration is valid";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}
else if($result == 4)
{
    $_SESSION['error'] = "Failed to apply<br>Please make sure that your replacement is from the same company and department";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}
else{
     $_SESSION['error'] = "Can't apply for this request<br>Please make sure that you didn't apply for a previous request that overlaps with this duration or that your annual leaves count is not enough";
    header("Location: /Database-Project/layout/appology.php");
    exit();
}
