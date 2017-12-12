<!DOCTYPE html>
<html>

<head>
    <title>Make a request</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="/Database-Project/style/staffMember.css" >
</head>

<body>

    <?php
 require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php");
?>



    <div id="RowStarter" class="row">
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>



        <!-- Form ----------------------------->

        <div class="container " style="margin-top:100px; ">
            <h1 style="text-align: center;">Apply for Business Trip Request</h1>
            <div class="col-xs-2"></div>
            <form class="form-horizontal col-xs-8" style="margin-top:50px;" action="/Database-Project/php/Staff-Member-Controller/business-request.php" method="post">


                <div class="form-group">
                    <label class="">Start-date:</label>
                    <input type="date" class="form-control" id="start_date" required="true" name="startDate">
                </div>


                <div class="form-group">
                    <label for="end_date">End-date:</label>
                    <input type="date" class="form-control" id="end_date" required="true" name="endDate">
                </div>


                <div class="form-group">
                    <label for="dest">Destination:</label>
                    <input type="text" class="form-control" id="dest" required="true" name="dest">
                </div>


                <div class="form-group">
                    <label for="rep">Replacement:</label>
                    <input type="text" class="form-control" id="rep" required="true" name="replacement">
                </div>


                <div class="form-group">
                    <label for="purpose">Purpose:</label>
                    <input type="text" class="form-control" id="purpose" required="true" name="purpose">
                </div>


                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-default ">Submit</button>
                    </div>
                </div>


            </form>
        </div>
    </div>

</body>

</html>
