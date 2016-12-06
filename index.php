<?php

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . "\samsen-night";
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');

session_start();

//Check welke pagina geladen moet worden
$page = '';
if(isset($_GET['p'])){

    $page = $_GET['p'];

} else {

    $page = 'home';

}

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

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "
        #sql
        SELECT userid, wachtwoord
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
        if (password_verify($password, $result['wachtwoord'])) {

            //Password is correct

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id']   = $result['userid'];
            header('Location: admin/cpanel.php');
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

function check_fill($input) {
    if (isset($_POST[$input]) && !empty($_POST[$input])) {
        return $_POST[$input];
    }
    return false;
}


//kijken of een veld verplicht is. Zo wel, en niet ingevuld, word de naam rood.
function required($input) {
    if (!isset($_POST[$input]) || empty($_POST[$input])) {
        return ' style="color:red;"';

    }
}

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

        <div class="container container-custom">

            <div class="row">

                <div class="col-xs-12 content">

                    <!--<div class="img-wrapper">

                        <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

                    </div>

                    <h1>Samsen Night</h1>

                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</p>
                    -->

                    <?php

                    if($contentresult > 1){

                        echo $contentresult[0];

                        if($contentresult[1] == 'Contact'){

                            if(isset($_POST["verzenden"])
                                &&
                                (empty($_POST['voornaam']) ||
                                    empty($_POST['achternaam']) || empty($_POST['onderwerp']) || empty($_POST['email']) || empty($_POST['bericht']))) {?>
                                <form method="post" action="index.php?p=Contact" id="contactpagina">

                                    <table>
                                        <tr>
                                            <td <?php print(required("voornaam")) ?>>Voornaam:</td> <td><input required type="text" name="voornaam" value= "<?php print(check_fill("voornaam")) ?>"></td></tr><tr>
                                            <td>Tussenvoegsel:</td> <td><input type="text" name="tussen" value= "<?php print($_POST["tussen"]) ?>"></td></tr><tr>
                                            <td <?php print(required("achternaam")) ?>>Achternaam:</td> <td><input required type="text" name="achternaam" value= "<?php print($_POST["achternaam"]) ?>"></td></tr><tr>
                                            <td>bedrijfsnaam:</td><td><input type="text" name="bedrijfsnaam" value= "<?php print($_POST["bedrijfsnaam"]) ?>"></td></tr><tr>
                                            <td <?php print(required("onderwerp")) ?>>Onderwerp:</td><td><input required type="text" name="onderwerp" value= "<?php print($_POST["onderwerp"]) ?>"></td></tr><tr>
                                            <td <?php print(required("email")) ?>>Email: </td><td><input required type="text" name="email" value= "<?php print($_POST["email"]) ?>"></td>
                                        </tr>
                                        <tr><td<?php print(required("bericht")) ?>>Bericht:</td></tr> <br>
                                    </table>

                                    <textarea  id="contactpagina" required form="contactpagina" name="bericht" rows="15" cols="50" wrap="soft"><?php print($_POST["bericht"]) ?></textarea><br>
                                    <input type="submit" name="verzenden" value="verzenden">
                                    <br>
                                    <h3 style="color: red; text-align: center;">rode velden zijn verplicht</h3>
                                </form>
                            <?php }elseif(!isset($_POST['verzenden'])){ ?>

                                <form method="post" action="index.php?p=Contact" id="contactpagina">
                                    <table>
                                        <tr>
                                            <td>Voornaam:</td> <td><input required type="text" name="voornaam"></td></tr><tr>
                                            <td>Tussenvoegsel:</td> <td><input  type="text" name="tussen"></td></tr><tr>
                                            <td>Achternaam:</td> <td><input required type="text" name="achternaam"></td></tr><tr>
                                            <td>bedrijfsnaam:</td><td><input type="text" name="bedrijfsnaam"></td></tr><tr>
                                            <td>Onderwerp:</td><td><input required type="text" name="onderwerp"></td></tr><tr>
                                            <td>Email: </td><td><input required type="email" name="email"></td></tr>
                                        </tr>
                                    </table>
                                    Bericht: <br>
                                    <textarea required id="contactpagina" name="bericht" rows="15" cols="50" wrap="soft"></textarea><br>
                                    <input type="submit" name="verzenden" value="verzenden">


                                </form>
                            <?php }
                            else{
                                print("<h4>" . "Bericht is verstuurd. U ontvangt zo spoedig mogelijk een bericht." . "</h4>");

                                $query = 'INSERT INTO formulier
                                        (voornaam, tussenvoegsel,  achternaam, email, bedrijfsnaam, onderwerp, bericht)
                                        VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :bedrijfsnaam, :onderwerp, :bericht)
                                        ';

                                $query= $dbh->prepare($query);
                                $query->bindParam(':voornaam', $_POST['voornaam']);
                                $query->bindParam(':tussenvoegsel', $_POST['tussen']);
                                $query->bindParam(':achternaam', $_POST['achternaam']);
                                $query->bindParam(':email', $_POST['email']);
                                $query->bindParam(':bedrijfsnaam', $_POST['bedrijfsnaam']);
                                $query->bindParam(':onderwerp', $_POST['onderwerp']);
                                $query->bindParam(':bericht', $_POST['bericht']);
                                $query->execute();
                            }


                        }
                    } else {

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