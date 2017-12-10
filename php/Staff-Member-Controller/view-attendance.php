<!DOCTYPE html>
<html>

<head>
    <title>View Attendance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Database-Project/style/Profile.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body style="text-align:center">
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>

    <h1 style="margin-top:100px;">Attendance Records</h1>
    <br><br>
    <div class="row">
        <div class="col-md-3">
        </div>





        <?php
// View my attendance records between start-date and end-date
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

//echo $start_date ."<br>".$end_date."<br>";

$result = (array)sqlExec("exec View_Attendance_Between_Certain_Period_Staff @SMusername = '".$_SESSION['userid']."' ,
@start_date = '".$start_date."' , @end_date = '".$end_date."'");

$result = json_decode(json_encode($result), true);


if(isset($result))
{
    // Success !
//    echo 'success!<br>';
//    print_r($result);
//    echo($result[0]['date']['date']);
//    echo $result[0]['staff']."<br>";
//    print_r($result[0]['start_time']);
    echo '
<table class="table table-striped table-hover table-bordered col-md-6"  style="width:  50% !important;  margin:auto; text-align:center">
    <thead>
        <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Missing hours</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
        ';
 
    for($i = 0 ; $i< sizeof($result);$i++) 
    { 
        echo '<tr>'. 
            '<td>'.substr($result[$i][ 'date'][ 'date'] , 0 , 10).'</td>'.
            '<td>'.substr($result[$i][ 'start_time']['date'] , 11,-10).'</td>'.
            '<td>'.substr($result[$i][ 'end_time']['date'],11,-10) .'</td>'.
            '<td>'.(int)substr($result[$i][ 'missing_hours']['date'] , 11,-13).'</td>'.
            '<td>'.substr($result[$i][ 'duration']['date'] , 11 , -10).'</td>'.
            '</tr>'; 
//        echo $result[$i][ 'date'][ 'date'];
    }
    



}
else 
{
            echo 'fail'; 
}?>



            </tbody>
            </table>

    </div>
    <div class="col-md-3">
    </div>
    </div>
</body>

</html>
