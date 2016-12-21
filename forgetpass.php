<?php
/**
 * Created by PhpStorm.
 * User: Wout
 * Date: 19/12/2016
 * Time: 09:48
 */

$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";

$error = "";
$error1 = "";
$error2 = "";
$results = 0;
$hoofd = "Geef hieronder uw geregistreerd e-mail adres op. U krijgt op dit adres een link toegestuurd om uw nieuwe wachtwoord toe te passen.";

include $base_path . '/includes/dbh.php';
include $base_path . '/includes/password.php';

if (isset($_POST['verstuur'])) {
    $email = $_POST['email'];
    $sql = "SELECT userid FROM user WHERE email = :email limit 1;";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(":email", $email);
    $sql->execute();
    $results = $sql->fetch();
    if ($results > 0) {
        $error = "U heeft geen geregistreerd e-mail adres opgegeven.";
    } else {
        function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
        {
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }
            return $str;
        }
        $passkey = random_str(12);

        $sql = "INSERT INTO user (passkey) VALUE :passkey WHERE email = :email;";
        $sql = $dbh->prepare($sql);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":passkey", $passkey);
        $sql->execute();

         $from = "noreply@samsennight.nl";
         $message = "<html><head>Wijziging wachtwoord Samsen Night</head><body>Geachte meneer/mevrouw,<br><br> 
         Wij hebben een verzoek gekregen om het wachtwoord dat bij dit e-mail adres hoort aan te laten passen. Hieronder is een link gepost die u deze handeling laat ondernemen.
         <br><br> Klik <a href='http://www.samsen-night.nl/forgotpass.php?key=".$passkey."' target='_blank'>hierop</a> om uw wachtwoord te wijzigen.<br><br> 
         Als u dit verzoek niet heeft ingediend, negeer dan s.v.p. dit bericht. 
         U heeft dan geen verdere actie te ondernemen. Met vriendelijke groet, de Samsen Night Groep</body></html>";
         mail($email, "Wijziging wachtwoord Samsen Night", $message);
    }
}
if (isset($_POST['finalize'])) {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $uppercase = preg_match('@[A-Z]@', $pass1);
    $lowercase = preg_match('@[a-z]@', $pass1);
    if ($pass1 != $pass2) {
        $error2 = ("Wachtwoorden moeten gelijk aan elkaar zijn.");
    } else {
        if (!$uppercase || !$lowercase || str_len($pass1 < 8)) {
            $error1 = ("Het wachtwoord moet voldoen aan de voorwaarden.");
        } else {
            $password = password_hash($pass1, PASSWORD_BCRYPT);
            $update = $dbh->prepare("UPDATE user SET wachtwoord = :password WHERE passkey = :passkey");
            $update->bindParam(':password', $password);
            $update->bindValue(':passkey', $passkey);
            $update->execute();
            $error = ("");
            header("Location: index.php");
        }
    }
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="http://localhost:8080/samsen-night/" >

    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>

<?php

    require_once('includes\menu.php');
    require_once('includes\dbh.php');
?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">
            <div class="img-wrapper">

                <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

            </div>
            <h1>Samsen Night</h1>
            <br> <br> <br> <?php echo $hoofd ?> <br> <br>
            <?php echo $error; ?> <br><br>
            <?php if(isset($_POST['verstuur']) && empty($_POST['email']) || empty($_POST['pass1']) || empty($_POST['pass2']))   { ?>
            <form method="POST" action="#">
                <div class="form-group">
                    <label for="exampleInputemail">Email adres</label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Vul hier uw e-mail adres in">
                </div>
                <button type="submit" name="verstuur" class="btn btn-primary">Verstuur</button>
            </form>
            <?php } elseif(isset($_POST['verstuur'])) {
                $hoofd = "Een e-mail is verstuurd naar het opgegeven adres. Volg de instructies die in deze mail staan.";
            } else {
                $email = $_POST['email'];
                $sql = "SELECT userid FROM user WHERE passkey = :key limit 1;";
                $sql = $dbh->prepare($sql);
                $sql->bindParam(":key", $_GET['key']);
                $sql->execute();
                $results = $sql->fetch();
            }
                if ($results > 0){
                ?>
                <form method="post" action="#">
                    <div class="form-group">
                        <label for="exampleInputemail">Nieuw wachtwoord</label> <?php echo ($error1); //error wordt getoond bij ongeldig wachtwoord  ?>
                        <input type="password" name="pass1" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Vul hier uw nieuwe wachtwoord in">
                        <small id="emailHelp" class="form-text text-muted">Een wachtwoord moet minimaal 8 tekens, één hoofdletter en één kleine letter bevatten.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputemail">Herhaling nieuw wachtwoord</label> <?php ($error2); //error wordt getoond bij ongelijk wachtwoord ?>
                        <input type="password" name="pass2" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Vul hier nogmaals uw nieuwe wachtwoord in">
                        <small id="emailHelp" class="form-text text-muted">Een wachtwoord moet minimaal 8 tekens, één hoofdletter en één kleine letter bevatten.</small>
                    </div>
                    <button type="submit" name="finalize" class="btn btn-primary">Verstuur</button>
                </form>
            <?php }?>
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