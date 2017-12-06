<?php

require("../../helper/sqlExec.php");

$result = sqlExec("SELECT  * FROM Users WHERE username = 'Arth'");

if(empty($result)){
    echo "NO RECORD!!!!";
}else
  print_r($result);
