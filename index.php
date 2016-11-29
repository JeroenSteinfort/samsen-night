<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 28/11/2016
 * Time: 11:25
 */
session_start();
$error = "";
require_once ('includes\password.php');

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

            include_once('includes/menu.php');

        ?>

        <div class="container container-custom">

            <div class="row">

                <div class="col-xs-12 content">
                    <div class="img-wrapper">

                        <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

                    </div>

                    <h1>Samsen Night</h1>

                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</p>

                </div>

            </div>

        </div>

        <?php

            include_once('includes/footer.php');

        ?>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>