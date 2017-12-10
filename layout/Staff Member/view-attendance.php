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
    <link rel="stylesheet" href="../../style/Profile.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); ?>
    <div id="RowStarter" class="row">
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>



        <div class="container" style="margin-top:100px; text-align: center;">
            <h1>View Attendance</h1>
            <form class="form-horizontal" style="margin-top:50px;" action="/./Database-Project/php/Staff-Member-Controller/view-attendance.php" method="post">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="start_date">Start-date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" placeholder="Start date" name="start_date" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="end_date">End-date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" placeholder="End Date" name="end_date" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</body>

</html>
