<!DOCTYPE html>
<html>

<head>
    <title>View Attendance</title>
</head>

<body>
    <?php
    // TODO Auth
    ?>
        <form action="/./Database-Project/php/Staff-Member-Controller/view-attendance.php" method="post">
            Start-date:
            <input type="date" name="start_date"> End-date:
            <input type="date" name="end_date">
            <input type="submit">
        </form>
</body>

</html>
