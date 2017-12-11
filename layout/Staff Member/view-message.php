<!DOCTYPE html>
<html>

<head>
    <title>Email</title>
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

<body style="">
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>

    <div class="container" style="margin-top:100px">

        <h1>View Mail</h1>
        <br>
        <div class="row">
            <div class="col-md-2"></div>

            <div class="panel col-md-8">
                <?php

                    $id = $_POST['id'];
                    
                    $mail = (array)sqlExec("select * from Emails where serial_number = ".$id." ");
                    $sender = (array)sqlExec("select * from Staff_send_Email_Staff where email_number = ".$id." ")[0];
                    
                    $mail = json_decode(json_encode($mail), true)[0];
                    
                    echo 'From: '.$sender['sender'].'<br>';
                    echo 'Subject: '.$mail['subject'].'<br>';
                    echo 'Body: '.$mail['body'];
                ?>
            </div>


            <div class="col-md-2"></div>

        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <form action="/Database-Project/layout/Staff Member/reply.php" method="post">
                <?php
                    echo '<button name = "id"  value= "'.$id.'" >Reply</button>'
                ?>
            </form>
        </div>


    </div>

</body>

</html>
