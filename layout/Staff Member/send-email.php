<!DOCTYPE html>
<html>

<head>
    <title>View Requests</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style/appology.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body>

    <?php     
// Staff Member view his/her requests
// TODO create front-end display
     require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");  require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php"); if(session_status() == PHP_SESSION_NONE) session_start(); ?>

    <br>
    <h1>Send Email</h1>
    <form action="/./Database-Project/php/Staff-Member-Controller/send-email.php" method="post">
        <label>To:</label>
        <input name="recipient" type="text">

        <br>

        <label>Subject:</label>
        <input name="subject" type="text">

        <br>

        <label>Body:</label>
        <textarea name="body" rows="5" cols="50"></textarea>

        <br>

        <input type="submit">
    </form>

</body>

</html>
