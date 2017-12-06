<?php

require("../connection/databaseConnection.php");

sqlsrv_configure("WarningsReturnAsErrors", 0);

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

     while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
     {
       $result[] = $row;
     }

	 $next_result = sqlsrv_next_result($stmt);

     while($next_result){

			 while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
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
