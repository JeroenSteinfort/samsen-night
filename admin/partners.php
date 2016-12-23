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




// hier haal ik alle rechten die de gebruiker heeft op
$sql = ' #sql
                                    SELECT r.recht as recht
                                    FROM recht as r
                                    JOIN heeft_recht as hr
                                    ON hr.rechten = r.rechtid
                                    JOIN rol
                                    ON rol.rolid = hr.rolid
                                    WHERE hr.rolid = :rolid 
                                ';
$sql = $dbh->prepare($sql);
$sql->bindParam(':rolid', $_SESSION['rolid']);
$sql->execute();
$result = $sql->fetchAll();

//alle rechten die de gebruiker worden op deze manier laten zien.
$contentbeheren=false;
$partnersbeheren=false;
$usersbeheren=false;
$tracksysteem=false;
$gebruiker=false;
foreach($result as $row) {

    if ($row['recht'] == "contentbeheren") {
        $contentbeheren=true;
    }
    if ($row['recht'] == "partnersbeheren") {
        $partnersbeheren=true;
    }
    if ($row['recht'] == "usersbeheren") {
        $usersbeheren=true;
    }
    if($row['recht'] == "tracksysteem"){
        $tracksysteem=true;
    }
    if($row['recht'] == "gebruiker"){
        $gebruiker=true;
    }
}


if(!isset($_SESSION['logged_in']) || $partnersbeheren == false) {

    header("Location: ../index.php");
    exit();

}

$error = "";

?>

<!DOCTYPE html>
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

include_once($base_path . '/includes/menu.php');

?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">

            <h1>CMS Partners Samsen Night</h1>

            <table class="tracker-table">
                <tr>    <th > PartnerID </th>
                    <th > Foto </th>
                    <th>  Partnernaam </th>
                    <th> Link </th>
                    <th> Beschrijving </th>
                    <th> Wijzig </th>
                    <th> Delete </th> </tr>

                <?php

                $userquery = $dbh->prepare("SELECT * FROM partners");
                $userquery->execute();

                $results = $userquery->fetchAll();
                // Bovenste gedeelte maakt link met CSS en de database connectie

                // bovenste gedeelte zijn headers voor tabel
                foreach ($results as $row) {
                    echo "<tr> <td>" .  $row['partnerid']  . " " . "</td>";
                    echo "<td>" .  $row['foto']  . " " . "</td>";
                    echo "<td>" .  $row['partnernaam']  . " " . "</td>";
                    echo "<td>" .  $row['link']  . " " . "</td>";
                    echo "<td>" .  $row['beschrijving']  . " " . "</td>";
                    echo "<td>" . "<form action='admin/partners.php' method='POST'><input type='text' value='" .  $row['partnerid']  . "' name='partnerid' style='display:none;'> <input type='submit' class=\"cms-submit\" value='Wijzig'  name='wijzig' class='cmsbutton'>" .  " </input </td> </form>";
                    echo "<td>" . "<form action='admin/partners.php' method='POST'><input type='text' value='" .  $row['partnerid']  . "' name='partnerid' style='display:none;'> <input type='submit' class=\"cms-submit\" value='Delete' name='delete' class='cmsbutton'>" . " </input>  </td> </form> ";
                    echo "<br> </tr>";
                    //Hier worden resultaten van de $results geshowed per regel. De delete en wijzig knop krijgen de waarde van het partner id. Een input waarde word niet geshowed maar word wel gebruikt.
                }
                ?>
            <?php

            //Bij het aanklikken van de 'wijzig' knop ontstaat de volgende vragenlijst
            if (isset($_POST['wijzig'])) { ?>
            <form method= 'POST' action= 'admin/partners.php'>
                <tr><td><?php echo $_POST['partnerid']?></td>
                <td><input type= 'file' name= 'foto' placeholder= 'Foto'></td>
                <td><input type= 'text' name= 'partnernaam' placeholder= 'Partnernaam'></td>
                <td><input type= 'text' name= 'link' placeholder= 'Link'></td>
                <td><input type= 'text' name= 'beschrijving' placeholder= 'Beschrijving'></td>
                <td><input type= 'submit' class=\"cms-submit\" value= 'Verzend' name= 'finalize' class= 'cmsbutton'></td>
                    <td><input type= 'hidden' name= 'partnerid' value=" <?= $_POST['partnerid'] ?>"></td></tr>
            </form>
            </table>
            <?php
            } else {

                echo "</table>";

            }

            //Hier wordt gevraagd om een bevestiging van je keuze. De meeste velden zijn verborgen en bestaan voor de overbrugging met de volgende SQL statement.
            if(isset($_POST['finalize']) && !empty($_POST['foto']) && !empty($_POST['partnernaam']) && !empty($_POST['beschrijving'])) {
            echo ("Weet u zeker dat u deze wijzigingen over ID" . $_POST['partnerid'] ." wilt toepassen?");
            ?>


            <form method="POST" action="admin/partners.php">
                <input type="submit" name="option" value="Ja" class="cmsbutton">
                <input type="submit" name="option" value="Nee" class="cmsbutton">
                <input type="hidden" name="partnerid" value="<?= $_POST['partnerid'] ?>">
                <input type="hidden" name="foto" value="<?= $_POST['foto'] ?>">
                <input type="hidden" name="partnernaam" value="<?= $_POST['partnernaam'] ?>">
                <input type="hidden" name="link" value="<?= $_POST['link'] ?>">
                <input type="hidden" name="beschrijving" value="<?= $_POST['beschrijving'] ?>">

                <input type="hidden" name="partnerid" value="<?= $_POST['partnerid'] ?>">
            </form>
            <?php } else {
                if (isset($_POST['finalize'])) {
                    echo ("Vul de verplichte gegevens in.");
                }
            }

            if(isset($_POST['option']) && $_POST['option'] == "Ja") {
                $update = $dbh->prepare("UPDATE partners SET foto = :foto, partnernaam = :partnernaam, link = :link, beschrijving = :beschrijving WHERE partnerid = :partnerid");
                $update->bindParam(':partnerid', $_POST['partnerid']);
                $update->bindValue(':foto', $_POST['foto']);
                $update->bindValue(':partnernaam', $_POST['partnernaam']);
                $update->bindValue(':link', $_POST['link']);
                $update->bindValue(':beschrijving', $_POST['beschrijving']);
                $update->execute();
                ?>
                <a href="http://localhost:8080/samsen-night/admin/partners.php">Refresh de pagina</a> <?php
                exit();
            }

            if(isset($_POST['delete'])) {
                Echo "Weet u zeker dat u de user met ID = " .  $_POST['partnerid']  . " wilt deleten?";
                ?>
                <form method="POST" action="admin/partners.php">
                    <input type="submit" name="optie" value="Ja" class="cms-submit">
                    <input type="submit" name="optie" value="Nee" class="cms-submit">
                    <input type="hidden" name="partnerid" value="<?= $_POST['partnerid'] ?>">
                </form>
                <?php
                // form hierboven kiest optie 1 of 2 and stuurt de user id door naaar de inhoud van de forms.
            }

            if (isset($_POST['optie']) && ($_POST['optie'] == "Ja")) {
                //als er op delete word geklikt en optie ja wordt gekozen word de onderste query gedraait.

                $delete = $dbh->prepare("DELETE from partners where partnerid = :partnerid");
                $delete->bindParam(':partnerid', $_POST['partnerid']);
                $delete->execute();
                ?>
                <a href="http://localhost:8080/samsen-night/admin/partners.php">Refresh de pagina</a> <?php
                exit();
                //na dat de query klaar is moet de pagina ververst worden.;
            }

            if (isset($_POST['optie']) && ($_POST['optie'] == "Nee")) {
                echo 'Deleten gecancelled.';
            }


            echo "<form action='admin/partners.php' method='POST'><input type='submit' class=\"cms-submit\" value='Toevoegen' name='toevoegen' class='cmsbutton'>" . " </input> </form>";

            //Bij het aanklikken van de 'toevoegen' knop ontstaat de volgende vragenlijst
            if (isset($_POST['toevoegen'])) { ?>
                <form method= 'POST' action= 'admin/partners.php'>
                    <tr><td></td>
                        <td><input type= 'file' name= 'foto' placeholder= 'Foto'></td>
                        <td><input type= 'text' name= 'partnernaam' placeholder= 'Partnernaam'></td>
                        <td><input type= 'text' name= 'link' placeholder= 'Link'></td>
                        <td><input type= 'text' name= 'beschrijving' placeholder= 'Beschrijving'></td>
                        <td><input type= 'submit' class=\"cms-submit\" value= 'Verzend' name= 'Tfinalize' class= 'cmsbutton'></td>
                        </tr>
                </form>
                </table>
                <?php
            } else {

                echo "</table>";

            }

            //Hier wordt gevraagd om een bevestiging van je keuze. De meeste velden zijn verborgen en bestaan voor de overbrugging met de volgende SQL statement.
            if(isset($_POST['Tfinalize']) && !empty($_POST['foto']) && !empty($_POST['partnernaam']) && !empty($_POST['beschrijving'])) {
                echo ("Weet u zeker dat u deze partner wilt toevoegen?");
                ?>


                <form method="POST" action="admin/partners.php">
                    <input type="submit" name="option" value="Ja toevoegen" class="cmsbutton">
                    <input type="submit" name="option" value="Nee toevoegen" class="cmsbutton">
                    <input type="hidden" name="foto" value="<?= $_POST['foto'] ?>">
                    <input type="hidden" name="partnernaam" value="<?= $_POST['partnernaam'] ?>">
                    <input type="hidden" name="link" value="<?= $_POST['link'] ?>">
                    <input type="hidden" name="beschrijving" value="<?= $_POST['beschrijving'] ?>">

                    <input type="hidden" name="partnerid" value="<?= $_POST['partnerid'] ?>">
                </form>
            <?php } else {
                if (isset($_POST['Tfinalize'])) {
                    echo ("Vul de verplichte gegevens in.");
                }
            }

            if(isset($_POST['option']) && $_POST['option'] == "Ja toevoegen") {
                $sql = $dbh->prepare("INSERT INTO partners (foto,partnernaam,link,beschrijving) VALUES (:foto, :partnernaam, :link, :beschrijving)");
                $sql->bindValue(':foto', $_POST['foto']);
                $sql->bindValue(':partnernaam', $_POST['partnernaam']);
                $sql->bindValue(':link', $_POST['link']);
                $sql->bindValue(':beschrijving', $_POST['beschrijving']);
                $sql->execute();
                ?>
                <a href="http://localhost:8080/samsen-night/admin/partners.php">Refresh de pagina</a> <?php
                exit();
            }

            if (isset($_POST['optie']) && ($_POST['optie'] == "Nee toevoegen")) {
                echo 'Toevoegen gecancelled.';
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