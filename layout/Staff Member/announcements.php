<!DOCTYPE html>
<html>

<head>
    <title>Announcements</title>
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

    <style>
        .panel {
            border: 3px solid;
            border-radius: 25px;
        }

        .announcements {
            margin: 10px;
        }

    </style>


</head>

<body style="">
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>

    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-md-2"></div>


            <div class="panel col-md-8">
                <h1>Inbox</h1>
                <?php

                    $result = (array)sqlExec("exec Check_Announcments @username = ".$_SESSION['userid']);
                
                    $result = json_decode(json_encode($result), true);
                
                
                    for($i = 0; $i < sizeof($result);$i++)
                    {
                        echo '<hr><div class = "row announcements">
                                <div class = "col-md-9">
                        ';
                        echo 'Date: '.$result[$i]['date']['date'].'<br>';
                        echo 'Title: '.$result[$i]['title'].'<br>';
                        echo 'Type: '.$result[$i]['type'].'<br>';
                        echo 'Description: '.$result[$i]['description'].'<br>';
                        echo '</div>
                            <div class = "col-md-3">
                               
                            </div>
                        </div>
                    <br>
                            ';
                    }
                ?>
            </div>


            <div class="col-md-2"></div>
        </div>

    </div>

</body>

</html>
