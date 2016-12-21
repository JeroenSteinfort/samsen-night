<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 02/12/2016
 * Time: 11:02
 */

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');
session_start();
// gaat door met sessie zodat hij weet of je ingelogd bent. anders terug naar home pagina
if(!isset($_SESSION['logged_in'])  ){ 

    header("Location: ../index.php");
    exit();

}

$error = "";

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <base href="http://localhost:8080/samsen-night/">
        
        <link rel="stylesheet" href="css/stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <?php
        
         $sql = ' #sql
                                    SELECT username, voornaam, tussenvoegsel, achternaam, wachtwoord, email
                                    FROM user
                                    WHERE userid = :userid
                                ';
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(':userid', $_SESSION['userid']);
                    $sql->execute();
                    $result = $sql->fetchAll();

            include_once($base_path . '/includes/menu.php');

        ?>

        <div class="container container-custom">

            <div class="row">

                <div class="col-xs-12 content">
                    <div class="img-wrapper">

                        <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">
                       

                    </div>
  
                    <h1>Account Beheren.</h1>
                    <p>
                        Beheer hier uw account. <br> <br>

                    </p>

                    <form method="post" action="accountbeheren.php">
                    <form method="post" action="index.php">
                        <?php if(isset($_POST["opslaan"])) {?>
                        Voornaam:  <input type="text" name="voornaam"  value= "<?php print($_POST["voornaam"]) ?>"> <br>
                        Achternaam: <input type="text" name="achternaam" value="<?php print($_POST["achternaam"]) ?>"><br>
                        Gebruikersnaam: <input type="text" name="username" value="<?php print ($_POST["username"]) ?>"> <br>
                        Wachtwoord: <input type="text" name="Wachtwoord" value="<?php print ($_POST["wachtwoord"]) ?>"><br>
                        Email: <input type="text" name="email" value="<?php print ($_POST["email"]) ?>"><br>
                        

                    </form>
                    <?php }else{ ?>

                    <form method="post" action="accountbeheren.php">
                        <table>
                            <tr><td>Gebruikersnaam:</td> <td><input type="text" name="Username"></td> </tr>    
                            <tr><td>Wachtwoord:</td> <td><input type="text" name="Wachtwoord"></td></tr>
                        <tr><td> Voornaam:</td>  <td><input type="text" name="voornaam"></td> </tr>
                        <tr><td>Tussenvoegsel:</td> <td> <input type="text" name="tussenvoegsel"></td> </tr> 
                        <tr><td>Achternaam:</td> <td><input type="text" name="achternaam"> </td> </tr>
                        <tr><td>bedrijfsnaam:</td> <td> <input type="text" name="bedrijfsnaam"> </td> </tr>
                        <tr><td>Email:</td> <td> <input type="text" name ="email"></td> </tr>
                        </table>
                        
                        <input type="submit" name="Opslaan" value="Opslaan">
                    </form>
                    <?php } ?>
                    





                </div>

            </div>

        </div>

        <?php

            include_once($base_path . '/includes/footer.php');

        ?>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                    
    </body>
</html>
</html>