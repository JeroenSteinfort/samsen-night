<?php

$base_path = $_SERVER['DOCUMENT_ROOT'];

$error = "";
$error1 = "";

if (isset($_POST['submit'])) {
    include 'includes\dbh.php';
    include 'includes\password.php';
    $username = $_POST['username'];
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $foto = $_POST['foto'];

    $sql = "SELECT userid FROM user where username = :username OR email = :email limit 1";

    $sql = $dbh->prepare($sql);
    $sql->bindParam(":username", $username);
    $sql->bindParam(":email", $email);
    $sql->execute();
    $results = $sql->fetch();
    if ($results > 0) {
        $error1 = "Username of Email is al ingebruik.";
    } else {

        if ($username ="" OR $voornaam = ""  OR $achternaam="" OR $password = "" {
        $error1 = "Je "


        }

        $sql = "INSERT INTO user (username, voornaam, tussenvoegsel, achternaam, password, email, foto)
VALUES (:username, :voornaam, :tussenvoegsel, :achternaam, :password, :email, :foto)";
        $sql = $dbh->prepare($sql);

        $sql->bindParam(":username", $username);
        $sql->bindParam(":voornaam", $voornaam);
        $sql->bindParam(":tussenvoegsel", $tussenvoegsel);
        $sql->bindParam(":achternaam", $achternaam);
        $sql->bindParam(":password", $password);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":foto", $foto);
        $sql->execute();

        header("Location: index.php");
    }
}
?>

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

<?php
require_once('includes\dbh.php');
?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">
            <div class="img-wrapper">

                <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

            </div>
            <?php
                echo $error1;
            ?>
            <h1>Samsen Night</h1>
            <br> <br> <br> <br> <br> <br> <br>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="exampleInputgebruikersnaam">Gebruikersnaam</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vul hier je gebruikersnaam">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputvoornaam">Voornaam</label>
                    <input type="text" name="voornaam" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vul hier je voornaam in">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputtussenvoegsel   ">Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vul hier eventueel je tussenvoegsel in">
                </div>
                <div class="form-group">
                    <label for="exampleachternaam">Achternaam</label>
                    <input type="text" name="achternaam" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vul hier je achternaam in">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else</small>
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Profiel foto</label>
                    <input type="file" class="form-control-file" name="foto" id="exampleInputFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">.PNG 50 x 50 pixels</small>
                </div>
                </fieldset>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            </p>

        </div>

    </div>

</div>

<?php

include_once('includes\footer.php');

?>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>