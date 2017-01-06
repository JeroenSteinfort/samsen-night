<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 02/12/2016
 * Time: 11:02
 */
function required($input) {
    if (!isset($_POST[$input]) || empty($_POST[$input])) {

        return ' style="color:red;"';

    }
}
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

                  
                         <?php
        $sql = '#sql
        SELECT *
        FROM user
        WHERE userid = :userid';
        $sql = $dbh->prepare($sql);
                    $sql->bindParam(':userid', $_SESSION['user_id']);
                    $sql->execute();
                    $result = $sql->fetch();
                    
                    if(!isset($_POST["verzenden"])) {
                                //&& 
                             //   (empty($result['voornaam']) || 
                               // empty($result['achternaam'])|| empty($result['email'] || empty($result['username']  )))){?> 
        
        <form method="result" action="accountbeheren.php"> 
         <table>
                            <tr>
                                <td <?php print(required("voornaam")) ?>>Voornaam:</td> <td><input type="text" class="form-control" name="voornaam" value= "<?php print($result["voornaam"]) ?>" ></td>
                            </tr>
                            <tr>
                                <td>Tussenvoegsel:</td>
                                <td><input type="text" name="tussen" class="form-control" value= ></td>
                            </tr>
                            <tr>
                                <td <?php print(required("achternaam")) ?>>Achternaam:</td>
                                <td><input type="text" name="achternaam" class="form-control" value= "<?php print($result["achternaam"]) ?>"></td>
                            </tr>
                            <tr>
                                <td>bedrijfsnaam:</td>
                                <td><input type="text" name="bedrijfsnaam" class="form-control" value= ></td>
                            </tr>
                            <tr>
                                <td <?php print(required("email")) ?>>Email: </td>
                                <td><input type="text" name="email" class="form-control" value= "<?php print($result["email"]) ?>"></td>
                            </tr>
                            <tr>
                                <td<?php print (required("Username")) ?>>Username: </td>
                                <td><input type="text" name="Username" class="form-control" value="<?php print ($result["username"]) ?>"></td>
                            </tr>
                            <tr>
                                <td<?php print(required("Wachtwoord")) ?>>Wachtwoord:</td>
                                <td><input type="text" name="wachtwoord" class="form-control" value =></td>
                            </tr>
                        </table>
            <input type="submit" class="cms-submit" name="verzenden" value="verzenden">
        </form>
                    <?php }
        ?>
 
                    
                        





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
