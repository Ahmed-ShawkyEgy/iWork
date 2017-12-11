<!DOCTYPE html>
<html>

<head>
    <title>Requests</title>
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

    <h1 style="margin-top:100px;">Requests Status</h1>
    <br><br>
    <div class="row">
        <div class="col-md-3">
        </div>
        <!-- Table inside form -->
        <form action="/Database-Project/php/Staff-Member-Controller/delete-requests.php" method="post">
            <table class="table table-striped table-hover table-bordered col-md-6" style="width:  50% !important;  margin:auto; text-align:center">
                <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>HR response</th>
                        <th>Manager response</th>
                        <th>HR employee</th>
                        <th>Manager</th>
                        <th>Delete Request</th>
                    </tr>
                </thead>
                <tbody>



                    <?php
// View my requests' status
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
        if (session_status() == PHP_SESSION_NONE)
            session_start();


$result = (array)sqlExec("exec View_All_Status_Requests @username = ".$_SESSION['userid']."");


$result = json_decode(json_encode($result), true);

    for($i = 0 ; $i< sizeof($result);$i++) 
    { 
        echo '<tr>'. 
            '<td>'.substr($result[$i][ 'request_date'][ 'date'] , 0 , 10).'</td>'.
            '<td>'.substr($result[$i][ 'start_date']['date'] , 0,10).'</td>'.
            '<td>'.substr($result[$i][ 'end_date']['date'],0,10) .'</td>'.
            '<td>'.$result[$i][ 'hr_response'].'</td>'.
            '<td>'.$result[$i][ 'manager_response'].'</td>'.
            '<td>'.$result[$i][ 'hr_employee'].'</td>'.
            '<td>'.$result[$i][ 'manager'].'</td>';
        
        if(!($result[$i]['hr_response']=='accepted' && $result[$i]['manager_response'] == 'accepted'))
        {
            echo '<td> <button type="submit" name="date" class="btn btn-warning" value="'.$result[$i]['start_date'][ 'date'].'">Delete</button></td>';
           
        }
        else{ echo "<td>Can't delete accepted requests</td>";}
        echo '</tr>';
    }
?>

                </tbody>
            </table>
        </form>
    </div>
    <div class="col-md-3"></div>
</body>

</html>
