<!DOCTYPE html>
<html>

<head>
    <title>Inbox</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Database-Project/style/staffMember.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


    <style>
        .panel {
            border: 3px solid;
            border-radius: 25px;
        }

        .mail {
            margin: 10px;
        }

    </style>
      <link rel="stylesheet" href="/Database-Project/style/staffMember.css">
</head>

<body style="">
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>

    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-md-2"></div>

            <form action="/Database-Project/layout/Staff Member/view-message.php" method="post">
                <div class="panel col-md-8">
                    <h1>Inbox</h1>
                    <?php

                    $result = (array)sqlExec("exec View_Email @username = ".$_SESSION['userid']);

                    $result = json_decode(json_encode($result), true);


                    for($i = 0; $i < sizeof($result);$i++)
                    {
                        echo '<hr><div class = "row mail">
                                <div class = "col-md-9">
                        ';
                        echo 'From: '.$result[$i]['sender'].'<br>';
                        echo 'Date: '.$result[$i]['date']['date'].'<br>';
                        echo 'Subject: '.$result[$i]['subject'];
                        echo '</div>
                            <div class = "col-md-3">
                               <button type="submit" name="id" class="btn btn-primary" value="'.$result[$i]['serial_number'].'">View Message</button>
                            </div>
                        </div>
                    <br>
                            ';
                    }
                ?>
                </div>


                <div class="col-md-2"></div>
            </form>
        </div>

    </div>

</body>

</html>
