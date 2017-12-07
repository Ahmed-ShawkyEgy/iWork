<!DOCTYPE html>
<html>

<head>
    <title>Authentication</title>
</head>

<body>

    <h1>
        <?php 
        session_start();
        if($_SESSION['error'] === null)
            $_SESSION['error'] = "Undefined Error";
        echo $_SESSION['error']?>
    </h1>

</body>

</html>
