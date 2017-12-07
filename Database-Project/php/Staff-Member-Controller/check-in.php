<?php

require("../../helper/sqlExec.php");
$x = sqlExec("insert into Companies values ('php@test.com', 'PHP','first Building above your glasses','@test.com','international','We want to end PHP','Just testing');");

echo $x;
//$result = sqlExec("SELECT  * FROM Users WHERE username = 'Arth'");
//
//if(empty($result)){
//    echo "NO RECORD!!!!";
//}else
//  print_r($result);
