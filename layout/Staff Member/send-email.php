<!DOCTYPE html>
<html>

<head>
    <title>View Requests</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Database-Project/style/staffMember.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link rel="stylesheet" href="/Database-Project/style/staffMember.css">
</head>

<body>

    <?php
// Staff Member view his/her requests
     require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");  require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>


    <div class="container " style="margin-top:100px; ">

        <h1 style="text-align: center;">Send Email</h1>

        <div class="col-xs-2"></div>

        <form class="form-horizontal col-xs-8" style="margin-top:50px;" action="/Database-Project/php/Staff-Member-Controller/send-email.php" method="post">

            <div class="form-group">
                <label>To:</label>
                <input name="recipient" type="text" class="form-control">
            </div>

            <br>


            <div class="form-group">
                <label>Subject:</label>
                <input name="subject" type="text" class="form-control">
            </div>
            <br>

            <div class="form-group">
                <label>Body:</label>
                <textarea name="body" rows="5" cols="50" class="form-control"></textarea>
            </div>

            <br>
            <input class='btn btn-primary' type='submit' name='searchButtonDep'  value = 'Submit'>
        </form>
    </div>
</body>

</html>
