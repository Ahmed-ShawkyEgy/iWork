<?php
// View my attendance records between start-date and end-date
// TODO re-create the respective procedure for this page
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

// TODO remove this line
$_SESSION['userid'] = "Arth";
// TODO add Session auth ie if($session == null) etc
