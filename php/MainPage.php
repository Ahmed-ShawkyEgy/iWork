<!DOCTYPE html>
<html>

<head>
  
</head>

<body>

    <h1>
      <?php

      require("../helper/sqlExec.php");
      session_start();
      $searchQuery =  post('searchText');
      $searchOption = $_POST['searchOption'];
      if($searchOption == "Name")
         $_SESSION['result'] = sqlExec("Exec search @name=$searchQuery");
      else if($searchOption == "Type")
          $_SESSION['result'] = sqlExec("Exec search @type=$searchQuery");
      else if($searchOption == "Address")
         $_SESSION['result'] = sqlExec("Exec search @address=$searchQuery");

      if(empty( $_SESSION['result']))
       echo "I LOVE YOU <3";
      else
       printTable( $_SESSION['result']);
       //print_r($result);

      ?>

    </h1>

</body>

</html>
