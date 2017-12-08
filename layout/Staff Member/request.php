<!DOCTYPE html>
<html>

<head>
    <title>Make a request</title>
</head>

<body>

    <?php 
//if($_SESSION==null or $_SESSION['type']!='staff member')
//{
//   header("Location: /layout/Appology/user-appology.html");
//   exit();
//}
?>

    <form action="/./Database-Project/php/Staff-Member-Controller/request.php" method="post">
        <label>Start Date:</label>
        <input name="startDate" type="date">

        <label>End Date:</label>
        <input name="endDate" type="date">

        <label>Type:</label>
        <input name="type" type="text">

        <label>Replacement:</label>
        <input name="replacement" type="text">

        <input type="submit">
    </form>

</body>

</html>
