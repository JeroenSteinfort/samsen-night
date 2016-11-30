<?php

$base_path = $_SERVER['DOCUMENT_ROOT'];

session_start();

$_SESSION['logged_in'] = true;

if(!isset($_SESSION['logged_in'])) {
    header("Location: ../index.php");
}

$error = "";

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= $base_path ?>/css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>

<?php

include_once($base_path . '/includes/menu.php');

?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">

            <h1>CMS Samsen Night</h1>


        </div>

    </div>

</div>

<?php

include_once($base_path . '/includes/footer.php');

?>
<<<<<<< HEAD
=======
<form action="includes\loguit.php" method="post">
    <input name="submit" type="submit" value="Loguit ">
</form>

<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 28/11/2016
 * Time: 11:25
 */
$error = "";
require_once ('..\includes\password.php');

$user = "root";
$password = "usbw";

$dbh = new PDO('mysql:host=localhost:3307;dbname=samsen-night',$user,$password);
if(isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "
        #sql
        SELECT userid, password
        FROM   user
        WHERE  username = :username
        LIMIT 1
        ";

    $query = $dbh->prepare($query);
    $query->bindParam(":username", $username);
    $query->execute();
    $result = $query->fetch();

    if ($result > 0) {

        //User is found
        if (password_verify($password, $result['password'])) {

            //Password is correct

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $result['userid'];
            header('Location: admin\cpanel.php');
            exit;

        } else {

            //Password is incorrect
            $error = "Username or password is incorrect";

        }

    } else {

        //User is not found
        $error = "Username or password is incorrect";

    }
}


?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>

<?php

include_once('includes\menu.php');

?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">
            <div class="img-wrapper">

                <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

            </div>

            <h1>Samsen Night</h1>

            <p>Welkom op het controle paneel.</p>

        </div>

    </div>

</div>

<?php

include_once('..\includes/footer.php');

?>
>>>>>>> origin/master

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>