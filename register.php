<?php
// Onderstaand document is door Ethan gemaakt.
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
// Errors worden gegenereerd door situaties in dit document. Ze worden dan ingevuld en staan zichtbaar bovenaan de pagina.
$error = "";
$error1 = "";
$error2= "";
$error3 = "";
$error4 = "";

include $base_path . '/includes/dbh.php';
include $base_path . '/includes/password.php';
// voegt het wachtwoord en db bestanden toe.
if (isset($_POST['submit']) && $_POST['g-recaptcha-response']&&$_POST['g-recaptcha-response'])  {
    $secret = "6Ld2cQ8UAAAAAFiJ3Nr7cJMb0bpDbkX4F8K-EtJH";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");
    $arr = json_decode($rsp, TRUE);
// Kijkt of de form gesubmit is en daarna of er een captcha response is.
    //kijkt of er een form gepost is
    $username = $_POST['username'];
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $password2 = $_POST["password2"];
    $password = $_POST["password"];
    $special = preg_match("#[\\~\\`\\!\\@\\#\\$\\%\\^\\&\\*\\(\\)\\_\\-\\+\\=\\{\\}\\[\\]\\|\\:\\;\\&lt;\\&gt;\\.\\?\\/\\\\\\\\]+#", $password); // kijkt of er een special teken voorkomt in de special in de password.
    if ($password != $password2) { // Wachtwoorden zijn niet hetzelfde.
        $error3 = "De wachtwoord velden zijn niet gelijk aan elkaar.";
    } else {
        if ( !$special || strlen($password) < 8) { //Als de wachtwoord niet langer is dan 8 tekens of geen speciaal teken bevat zal de wachtwoord niet worden geaccepteerd.
            $error2 = "Wachtwoord voldoet niet aan de eisen.";

                  } else {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); //hashed het wachtwoord.
            $email = $_POST['email'];
            $sql = "SELECT userid FROM user where username = :username OR email = :email limit 1";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(":username", $username);
            $sql->bindParam(":email", $email);
            $sql->execute();
            $results = $sql->fetch();
            if ($results > 0) {
                $error1 = "Username of Email is al ingebruik.";
                // ^ word er gekeken of de username of email al voorkomt in onze database.
            } else {
                if ($username == "" OR $voornaam == "" OR $achternaam == "" OR $password == "") {
                    $error1 = "Er zijn velden niet ingevuld die verplicht zijn. ";
                    // Als velden niet ingevuld zijn.

                } else {

                    $sql = "
                    INSERT INTO user (username, voornaam, tussenvoegsel, achternaam, wachtwoord, email)
                    VALUES (:username, :voornaam, :tussenvoegsel, :achternaam, :password, :email)";
                    $sql = $dbh->prepare($sql);

                    $sql->bindParam(":username", $username);
                    $sql->bindParam(":voornaam", $voornaam);
                    $sql->bindParam(":tussenvoegsel", $tussenvoegsel);
                    $sql->bindParam(":achternaam", $achternaam);
                    $sql->bindParam(":password", $password);
                    $sql->bindParam(":email", $email);

                    $sql->execute();
                    //Indien alle gegevens correct zijn, alle verplichte velden zijn ingevuld en er geen dubbele naam of mail voorkomt

                    $userid = $dbh->lastInsertId();

                    $sql = '
                    #sql
                    INSERT INTO login (attempts, active, userid)
                    VALUES (0, 1, :userid) 
                    ';
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(":userid", $userid);
                    $sql->execute();
                    // Bovenste gedeelte is van mathijs, dit voegt een paar gegevens toe aan het login table.


                    header("Location: index.php");
                    //Wanneer alles goed gegaan is zal hij de usergegevens in de database zetten en u naar de index brengen.

                }

            }
        }
    }
} elseif (isset($_POST['submit']) && !$_POST['g-recaptcha-response'] || $_POST['g-recaptcha-response'])  {
    $error4= "U heeft geen captcha ingevuld"; // Geen captcha response of niet ingevuld.
}

?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://www.google.com/recaptcha/api.js?hl=nl'></script>
    <base href="http://localhost:8080/samsen-night/" >

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
                echo $error4;
            ?>
            <h1>Samsen Night</h1>
            <br> <br> <br> <br> <br> <br> <br>
            <?php if(isset($_POST["submit"]) // Indien er een form is ingevuld en deze niet door de check heen komt krijg je gegevens terug. Dit zie je dus als er een empty veld is die wel verplicht.
            &&
            (empty($_POST['gebruikersnaam']) ||
                empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2']))) {?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="exampleInputgebruikersnaam">Gebruikersnaam</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" value= "<?php print($_POST["username"]) ?>" aria-describedby="emailHelp" placeholder="Vul hier je gebruikersnaam">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputvoornaam">Voornaam</label>
                    <input type="text" name="voornaam" class="form-control" id="exampleInputEmail1" value= "<?php print($_POST["voornaam"]) ?>" aria-describedby="emailHelp" placeholder="Vul hier je voornaam in">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputtussenvoegsel   ">Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel" class="form-control" id="exampleInputEmail1" value= "<?php print($_POST["tussenvoegsel"]) ?>" aria-describedby="emailHelp" placeholder="Vul hier eventueel je tussenvoegsel in">
                </div>
                <div class="form-group">
                    <label for="exampleachternaam">Achternaam</label>
                    <input type="text" name="achternaam" class="form-control" id="exampleInputEmail1" value= "<?php print($_POST["achternaam"]) ?>" aria-describedby="emailHelp" placeholder="Vul hier je achternaam in">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" value= "<?php print($_POST["email"]) ?>" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>                 <?php echo $error2; //als er een wachtwoord fout is opgetreden word hij hier getoont.?>
                    <input type="password" name="password" class="form-control" value= "<?php print($_POST["password"]) ?>" id="exampleInputPassword1" placeholder="Password">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld, wachtwoord moet voldoen aan minimaal 8 tekens, een hoofdletter en kleine letters.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2"> Password opnieuw typen.</label>                 <?php echo $error3; //als er een wachtwoord fout is opgetreden word hij hier getoont.?>
                    <input type="password"  name="password2" class="form-control" value= "<?php print($_POST["password2"]) ?>" id="exampleInputPassword2" placeholder="Password">
                </div>
                <br><div class="g-recaptcha" data-sitekey="6Ld2cQ8UAAAAAP1Tg9tRgFhkU14XDHW77r0Hzx9H"></div> <br>
                </fieldset>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php }elseif(!isset($_POST['verzenden'])){ ?>
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
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>    <?php echo $error2; //als er een wachtwoord fout is opgetreden wordt hij hier getoont.?>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    <small id="emailHelp" class="form-text text-muted">Verplicht veld, wachtwoord moet voldoen aan minimaal 8 tekens, een hoofdletter en kleine letters.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2"> Password opnieuw typen.</label>    <?php echo $error3; //als er een wachtwoord fout is opgetreden wordt hij hier getoont.?>
                    <input type="password"  name="password2" class="form-control" id="exampleInputPassword2" placeholder="Password">
                </div>
                <br><div class="g-recaptcha" data-sitekey="6Ld2cQ8UAAAAAP1Tg9tRgFhkU14XDHW77r0Hzx9H"></div> <br>
                </fieldset>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php } ?>
            </p>

        </div>

    </div>

</div>

<?php

include_once('includes\footer.php');

?>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Catpcha -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>