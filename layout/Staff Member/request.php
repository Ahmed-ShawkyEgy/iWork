<!DOCTYPE html>
<html>

<head>
    <title>Make a request</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../style/Profile.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body>

    <?php 
 require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/axess.php"); 
?>



    <div id="RowStarter" class="row">
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/php/navbar.php"); ?>



        <div class="container" style="margin-top:100px; text-align: center;">
            <h1>Apply for request</h1>
            <form class="form-horizontal" style="margin-top:50px;" action="/./Database-Project/php/Staff-Member-Controller/request.php" method="post">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="startDate">Start-date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" placeholder="Start date" name="startDate" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="endDate">End-date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" placeholder="End Date" name="endDate" required="true">
                    </div>
                </div>
                <br>

                <div class="col-xs-3">
                    <div class="form-group">
                        <select class="selectpicker form-control" size="1">
        <option>Mustard</option>
        <option>Ketchup</option>
        <option>Relish</option>
      </select>
                    </div>
                </div>



                <br>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="replacement">Replacement:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="User Name" name="replacement" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>


            </form>
        </div>







        <!-- Form ----------------------------->

        <div class="container" style="margin-top:100px; text-align: center;">
            <h1>Apply for request</h1>
            <form class="form-horizontal" style="margin-top:50px;" action="/./Database-Project/php/Staff-Member-Controller/request.php" method="post">


                <div class="form-group">
                    <label for="start_date">Start-date:</label>
                    <input type="date" class="form-control" id="start_date" required="true" name="startDate">
                </div>


                <div class="form-group">
                    <label for="end_date">End-date:</label>
                    <input type="date" class="form-control" id="end_date" required="true" name="endDate">
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect2">Example multiple select</label>
                    <select multiple class="form-control" id="exampleFormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
