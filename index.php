<?php

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
require_once($base_path . '/includes/password.php');
require_once($base_path . '/includes/dbh.php');
require_once($base_path . '/includes/tracker.php');

session_start();

//Check welke pagina geladen moet worden
$page = '';
if(isset($_GET['p'])){

    $page = $_GET['p'];

} else {

    $page = 'Home';

}

//Haal content op op basis van paginanaam
$sql = "
#sql
SELECT content, naam
FROM   pagina
WHERE  naam = :page
LIMIT  1
";

$sql = $dbh->prepare($sql);
$sql->bindParam(':page', $page);
$sql->execute();

$contentresult = $sql->fetch();

$error = "";

//Login Check
if(isset($_POST['login'])) {

    //Geposte username en wachtwoord
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Haal gebruiker, wachtwoord en rol van de gebruiker op uit database
    $query = "
        #sql
            SELECT rol.rolid as rolid, u.userid as userid, u.wachtwoord as wachtwoord
            FROM heeft_recht AS hr 
            JOIN rol AS rol 
            ON  hr.rolid = rol.rolid 
            JOIN user AS u 
            ON u.rolid = rol.rolid
            WHERE  username = :username
            LIMIT 1

        ";

    $query = $dbh->prepare($query);
    $query->bindParam(":username", $username);
    $query->execute();
    $result = $query->fetch();

    if ($result > 0) {

        //Er is een user gevonden, check of het account nog actief is
        $query = '
        #sql
        SELECT active, attempts 
        FROM login as l
        JOIN user as u 
        ON l.userid = u.userid
        WHERE u.username = :username
        LIMIT 1
        
        ';
        $query = $dbh->prepare($query);
        $query->bindParam(":username", $username);
        $query->execute();
        $resultaat = $query->fetch();

        //Account is wel actief maar heeft het aantal pogingen overschreden
        if($resultaat['attempts'] >= 4 ){
            $query = '
                #sql
            UPDATE login 
            SET active = 0, attempts = 0
            WHERE userid = :userid';

            //Mail sturen naar beheerder
            $query = $dbh->prepare($query);
            $query->bindParam(":userid", $result['userid']);
            $query->execute();
            $to = "adminsamsennight@hotmail.com";
            $onderwerp = "account is geblokkeerd";
            $bericht = "het account met id " . $result['userid'] . " is geblokkeerd. ";
            $van = "From: noreply@samsennight.com";
            mail($to, $onderwerp, $bericht, $van);

            //Mail sturen naar account houder
            $query =  "
            #sql
            SELECT email 
            FROM user
            WHERE userid = :userid
            ";
            $query = $dbh->prepare($query);
            $query->bindParam(":userid", $result['userid']);
            $query->execute();
            $email = $query->fetch();
            $onderwerp = "uw account is geblokkeerd";
            $bericht = "volgens onze gegevens is er meer dan 5x geprobeerd om in te loggen op uw account <br> 
            om uw account weer te activeren moet u een mail sturen naar adminsamsennight@hotmail.com";
            mail($email["email"], $onderwerp, $bericht, $van);

        }


        //Gebruiker is gevonden, actief en het wachtwoord klopt
        if (password_verify($password, $result['wachtwoord']) && $resultaat['active'] == 1) {

            //Password is correct && admin recht is gedefinieerd
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id']   = $result['userid'];
            $_SESSION['rolid']     = $result['rolid'];

            // de attempts worden gereset
            $query = '
            #sql
            UPDATE login
            SET attempts = 0
            WHERE userid = :userid
            ';
            $query = $dbh->prepare($query);
            $query->bindParam(":userid", $result['userid']);
            $query->execute();


            header('Location: admin/cpanel.php');
            exit;

        }

        if($resultaat['active'] == 1 && $resultaat['attempts'] <=4) {
            //password is fout, bij attempts word 1 bij op getelt.
            $resultaat['attempts'] = $resultaat['attempts'] +1;

            $query = '
            #sql
            UPDATE login 
            SET attempts = :attempts
            WHERE userid = :userid
            ';

            $query = $dbh->prepare($query);
            $query->bindParam(":userid", $result['userid']);
            $query->bindParam(":attempts", $resultaat['attempts']);
            $query->execute();


            //Password is incorrect
            $error = "Username or password is incorrect";

        }
        else {
            //account is geblokkeerd
            $error = "Account is blocked";
        }

    } else {

        //User is not found
        $error = "Username or password is incorrect";

    }

}

//User tracker functies
newVisitor($dbh, $page);

?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <base href="http://localhost:8080/samsen-night/">

        <link rel="stylesheet" href="css/stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    </head>
    <body>


        <?php

            include_once($base_path . '/includes/menu.php');

        ?>

        <div class="container container-custom carousel-fade">

            <div class="row">

                <div class="col-xs-12 content">



                    <!--<div class="img-wrapper">

                        <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

                    </div>

                    <h1>Samsen Night</h1>

                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</p>
                    -->

                    <?php

                    if($contentresult > 1) {

                        echo $contentresult[0];

                        if($page == "Home"){

                            require_once($base_path . '/includes/slider.php');

                        }

                        if($contentresult['naam'] == 'Contact') {

                            require($base_path . '/contactpagina.php');

                        } elseif(isset($_GET['p']) && $_GET['p'] == 'Partners') {

                            require($base_path . '/partners.php');

                        }

                    } elseif(isset($_GET['p']) && $_GET['p'] == 'algemene-voorwaarden'){

                        require($base_path . '/algemene-voorwaarden.php');


                    }else {

                        echo '<p>Pagina is niet gevonden</p>';

                    }

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