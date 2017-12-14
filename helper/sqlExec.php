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

/*

<select name="searchOption">
   <option value="Name">Name</option>
   <option value="Type">Type</option>
   <option value="Address">Address</option>
</select>


*/


function printTableProjects($array,$filepath){
print("</br>");
print("</br>");
echo "<form action='".$filepath."' method='post'><select name='searchOption'>";
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
    if($key=='name'){
    //  echo $key." : &nbsp;&nbsp;&nbsp;";

      echo "<option value='".$value."'>".$value."</option>";

    }

  }

 }
 echo "</select><input class='btn btn-primary' type='submit' name='searchButton'  value = 'Search'></form>";
 print("</br>");print("</br>");
}




function printTableDateTime($array){

print("</br>");
print("</br>");
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
      echo $key." : &nbsp;&nbsp;&nbsp;";
      if(gettype($value)!='object'){
      echo $value;
    }else {
      echo $value->format("Y-m-d");
      }
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

      echo "&nbsp;&nbsp;&nbsp;";
    }
    else {
      if($key == 'Salary'){
      $pos = strrpos($value, ".");
      echo "<span style ='border-style: inset;'>".substr($value, 0, $pos)."</span>";

      print("</br>");print("</br>");
            echo "</form>";
    }
    }

  }

 }
}


function printTableQuestions($array){

print("</br>");
print("</br>");
$_SESSION['modelAnswer'] = array(count($array));
for($row = 0; $row < count($array);$row++){
  foreach ($array[$row] as $key => $value){
    if($key=='question'){
    //  echo $key." : &nbsp;&nbsp;&nbsp;";
      echo "<form action='/Database-Project/php/Job-Seeker-Controller/interviewQuestions.php' method='post'>";
      echo $value." &nbsp;&nbsp"."<input type='radio' name='Option".$row."' value='1' style='transform: scale(3);' > True <input type='radio' name='Option".$row."' value='0' style='transform: scale(3);' > False<br>";
      //echo ("'Option".$row."'");
      print("</br>");print("</br>");
    }
    else{
      $_SESSION['modelAnswer'][$row]=$value;
      //echo $_SESSION['modelAnswer'][$row];
    }

  }

 }
   echo "<input class='btn btn-primary' type='submit' name='searchButtonDep'  value = 'Submit' style='height:60px;width:200px;font-size:30px'></form>";
}




function printTableApplication($array){

print("</br>");
print("</br>");
$row = 0;
while( $row < count($array)){
  foreach ($array[$row] as $key => $value){
    echo "<form action='/Database-Project/php/Job-Seeker-Controller/deleteJobApplication.php' method='post'>";
    echo $key." : &nbsp;&nbsp;&nbsp;";
    //".$key." disabled
    echo "<input type='text' name='".$key."' value='".$value."'  style='background-color: rgba(255,0,0,0);border:none;width:25em' readonly >";
    if($key=='company'){
      print("</br>");
      echo " &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "<input class='btn btn-danger' type='submit' name='DelButton'  value = 'Delete' style='height:60px;width:200px;font-size:30px'>";
      echo "</form>";
      $row++;
      break;
    }
    print("</br>");

  }

  print("</br>");print("</br>");

 }

}




function printTableApplicationAccepted($array){

print("</br>");
print("</br>");
$row = 0;
while( $row < count($array)){
  foreach ($array[$row] as $key => $value){
    echo "<form action='/Database-Project/php/Job-Seeker-Controller/chooseJob.php' method='post'>";
    echo $key." : &nbsp;&nbsp;&nbsp;";
    //".$key." disabled
    echo "<input type='text' name='".$key."' value='".$value."'  style='background-color: rgba(255,0,0,0);border:none;width:25em' readonly >";
    if($key=='company'){
      print("</br>");
      echo " &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "<input class='btn btn-danger' type='submit' name='SelectButton'  value = 'Select' style='height:60px;width:200px;font-size:30px'>";
      echo "</form>";
      $row++;
      break;
    }
    print("</br>");

  }

  print("</br>");print("</br>");

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
