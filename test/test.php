<?php

require("../helper/sqlExec.php");
$username = 'Trissy';
$result = sqlExec("exec View_Attendance @username= $username");
print_r($result);

?>
