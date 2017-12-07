<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/connection/databaseConnection.php");

sqlsrv_configure("WarningsReturnAsErrors", 0);
/*-------------- Handling Functions--------------------*/
function post($name) {
  $res = stripslashes($_POST[$name]);
  return is_string($res) ? "'". $res ."'" : $res;
}

function printTable($array){

  /*while (current($array[0])) {
      echo key($array[0])."&nbsp;&nbsp;&nbsp;";
      next($array[0]);
}*/
print("</br>");
print("</br>");
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
      echo $key." : &nbsp;&nbsp;&nbsp;";
      echo $value;
      print("</br>");
  }
  print("</br>");
  print("</br>");
 }
}


function printTableLinks($array){

print("</br>");
print("</br>");
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
    if($key=='name'){
      echo $key." : &nbsp;&nbsp;&nbsp;";
      echo $value;
      print("</br>");print("</br>");
    }

  }

 }
}


/* ------------- Error Handling Functions --------------*/
function DisplayErrors()
{
     $errors = sqlsrv_errors(SQLSRV_ERR_ERRORS);
     foreach( $errors as $error )
     {
         echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
         echo "code: ".$error[ 'code']."<br />";
         echo "Error: ".$error['message']."\n";
     }
}

function DisplayWarnings()
{
     $warnings = sqlsrv_errors(SQLSRV_ERR_WARNINGS);
     if(!is_null($warnings))
     {
          foreach( $warnings as $warning )
          {
               echo "SQLSTATE: ".$warnings[ 'SQLSTATE']."<br />";
               echo "code: ".$warnings[ 'code']."<br />";
               echo "Warning: ".$warning['message']."\n";
          }
     }
}

/* ------------- Mssql Execution Function --------------*/
function sqlExec($sql){

     $result = [];

     $stmt = sqlsrv_query($GLOBALS['conn'], $sql,array(),array( "Scrollable" => 'static' ));

     if(!$stmt) {
        die( print_r( sqlsrv_errors(), true));
     }

     while ($row = sqlsrv_fetch_object( $stmt))
     {
       $result[] = $row;
     }

	 $next_result = sqlsrv_next_result($stmt);

     while($next_result){

			 while ($row = sqlsrv_fetch_object( $stmt))
             {
               $result[] = $row;
             }

			 $next_result = sqlsrv_next_result($stmt);
	 }
      //DisplayErrors();
    //  DisplayWarnings();

    return $result;

}

?>
