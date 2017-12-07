

<?php

require("../connection/databaseConnection.php");

function sqlExec($sql){

$substr = str_replace("@"," ",substr($sql,strpos($sql,"@")));

$substrArray = explode(',',$substr);

$sqlIn = substr($sql,0,strpos($sql,"@"));

for ($x = 0; $x < count($substrArray); $x++) {
	$sub = explode('=',$substrArray[$x]);
    $params[$sub[0]] = $sub[1];
	$procedure_params[$x] = array(&$params[$sub[0]]);
	if($x == 0)$sqlIn = $sqlIn ."@".str_replace(' ', '', $sub[0])."= ?";
	else$sqlIn = $sqlIn ." , @".str_replace(' ', '', $sub[0])."= ?";
}

$stmt = sqlsrv_prepare($GLOBALS['conn'], $sqlIn, $procedure_params, array( "Scrollable" => 'static' ));

if(!$stmt) {
   die( print_r( sqlsrv_errors(), true));
}

if(is_resource($stmt))
   return $stmt;

return null;		
}



?>