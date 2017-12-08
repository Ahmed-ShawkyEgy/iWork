<!DOCTYPE html>
<html>

<head>
    <title>View Requests</title>
</head>

<body>

    <?php     
// Staff Member view his/her requests
// TODO create front end form
// TODO create front end display
require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();

    
// TODO remove this line
$_SESSION['userid'] = "Trissy";
// TODO add Session auth ie if($session == null) etc
//if($_SESSION==null or $_SESSION['type']!='staff member')
//{
//   header("Location: /layout/Appology/user-appology.html");
//   exit();
//}


$result = (array)sqlExec("exec View_All_Status_Requests @username = ".$_SESSION['userid']."");



$array = json_decode(json_encode($result), true);

if(isset($array))
{
    // Success !
    echo 'Success!';
    print_r($result);
    
    
    print("</br>");
    print("</br>");
    for($row = 0; $row < count($array);$row++)
    {
        for ($array[$row] as )
        {
//            echo $key." : &nbsp;&nbsp;&nbsp;";
//            echo $value;
            echo $array[$row][$col] ."  ,  ";
//            print("</br>");
        }
        print("</br>");
        print("</br>");
    }
}
    
    
else
{
    // Fail :(
    echo 'fail';
}

?>

</body>

</html>
