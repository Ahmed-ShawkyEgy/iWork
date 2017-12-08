<?php
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/connection/databaseConnection.php");

sqlsrv_configure("WarningsReturnAsErrors", 0);
/*-------------- Handling Functions--------------------*/
function post($name) {
  $res = stripslashes($_POST[$name]);
  return is_string($res) ? "'". $res ."'" : $res;
}

function printTable($array){

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
    //  echo $key." : &nbsp;&nbsp;&nbsp;";
      echo "<form action='/Database-Project/php/viewDetails.php' method='post'>";
      echo $key.":"."<input type='submit' style='background: rgba(54, 25, 25, 0);' name= 'selectedCompany' value= '".$value."'>";
      echo "</form>";
      print("</br>");print("</br>");
    }

  }

 }
}




function printTableWithCarryon($array){;
$tmpArray=array(count($array)*2);
$index=0;
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
      if($key!='Dep' && $key!='code'&& $row == 0){
      echo $key." : &nbsp;&nbsp;&nbsp;";
      echo $value;
      print("</br>");
    }
    else{
      if($key=='Dep' || $key=='code'){
      $tmpArray[$index]=$key." : &nbsp;&nbsp;&nbsp;". $value;
      $index++;
    }
    }
  }

}
 for($row = 0; $row < count($tmpArray);$row++){
   echo $tmpArray[$row];
   print("</br>");
 }
}



function printTableWithCarryonDep($array){;
$tmpArray=array(count($array)*2);
$index=0;
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
      if($key!='title' && $row == 0){
      echo $key." : &nbsp;&nbsp;&nbsp;";
      echo $value;
      print("</br>");
    }
    else{
      if($key=='title'){
      $tmpArray[$index]=$key." : &nbsp;&nbsp;&nbsp;". $value;
      $index++;
    }
    }
  }

}
 for($row = 0; $row < count($tmpArray);$row++){
   echo $tmpArray[$row];
   print("</br>");
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
