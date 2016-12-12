<?php

session_start();
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 02/12/2016
 * Time: 11:02
 */
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
include $base_path . '/includes/dbh.php';
?>
<link rel="stylesheet" type="text/css" href="css\stylesheet.css">
<?php

$userquery = $dbh->prepare("Select * from user");
$userquery->execute();

$results = $userquery->fetchAll();
// Bovenste gedeeltje maakt link met CSS en de database connectie

?>




    <table class="cms">
    <th class="cms"> UserID </th>
    <th class="cms"> Username </th>
        <th class="cms"> Voornaam </th>
    <th class="cms"> Tussenvoegsel </th>
    <th class="cms"> Achternaam </th>
    <th class="cms"> Email </th>
    <th class="cms"> Foto </th>
    <th class="cms"> Rolid </th>
        <th class="cms"> Wijzig </th>
        <th class="cms"> Delete </th>

    <?php
    // bovenste gedeelte zijn headers voor tabel
foreach ($results as $row) {
    echo "<tr class=\"cms\"> <td class=\"cms\">" .  $row['userid']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['username']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['voornaam']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['tussenvoegsel']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['achternaam']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['email']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['foto']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['rolid']  . " " . "</td>";
    echo "<td class=\"cms\">" . "<form action='#' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' value='Wijzig' name='wijzig' class='cmsbutton'>" . " </input> </td> </form>";
    echo "<td class=\"cms\">" . "<form action='#' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' value='Delete' name='delete' class='cmsbutton'>" . " </input> </td> </form>";
    echo "<br> </tr>";
    //Hier worden resultaten van de $results getoond per regel. De delete- en wijzigknop krijgen de waarde van de user-id. Een input waarde wordt niet getoont maar wordt wel gebruikt.
}
?>
</table>
<br>

<?php

//Bij het aanklikken van de 'wijzig' knop ontstaat de volgende vragenlijst
if (isset($_POST['wijzig'])) { ?>
    <form method= 'POST' action= '#'>
          <input type= 'text' name= 'vnaam' placeholder= 'Voornaam'>
          <input type= 'text' name= 'tv' placeholder= 'Tussenvoegsel'>
          <input type= 'text' name= 'anaam' placeholder= 'Achternaam'>
          <input type= 'text' name= 'email' placeholder= 'E-mail'>
          <input type= 'text' name= 'foto' placeholder= 'Foto'>
          <input type= 'submit' value= 'Verzend' name= 'finalize' class= 'cmsbutton'>
          <input type= 'hidden' name= 'userid' value=" <?= $_POST['userid'] ?>">
          </form> <?php ;
}

if(isset($_POST['finalize']) && !empty($_POST['vnaam']) && !empty($_POST['anaam']) && !empty($_POST['email'])) {
    echo ("Weet u zeker dat u deze wijzigingen over" . $_POST['userid'] ." wilt toepassen?");
    ?>
    <form method="POST" action="#">
        <input type="submit" name="option" value="Ja" class="cmsbutton">
        <input type="submit" name="option" value="Nee" class="cmsbutton">
        <input type="hidden" name="userid" value="<?= $_POST['userid'] ?>">
        <input type="hidden" name="vnaam" value="<?= $_POST['vnaam'] ?>">
        <input type="hidden" name="tv" value="<?= $_POST['tv'] ?>">
        <input type="hidden" name="anaam" value="<?= $_POST['anaam'] ?>">
        <input type="hidden" name="email" value="<?= $_POST['email'] ?>">
        <input type="hidden" name="foto" value="<?= $_POST['foto'] ?>">
    </form>
    <?php
} else {
    if (isset($_POST['finalize'])) {
        echo ("Vul de verplichte gegevens in.");
    }
}

if(isset($_POST['option']) && $_POST['option'] == "Ja") {
    $update = $dbh->prepare("UPDATE user SET voornaam = :vnaam, tussenvoegsel = :tv, achternaam = :anaam, 
                             email = :email, foto = :foto WHERE userid = :userid");
    $update->bindParam(':userid', $_POST['userid']);
    $update->bindValue(':vnaam', $_POST['vnaam']);
    $update->bindValue(':tv', $_POST['tv']);
    $update->bindValue(':anaam', $_POST['anaam']);
    $update->bindValue(':email', $_POST['email']);
    $update->bindValue(':foto', $_POST['foto']);
    $update->execute();
    header("Location: users.php");
    exit;
}


if(isset($_POST['delete'])) {
    echo "Weet u zeker dat u de user met ID = " .  $_POST['userid']  . " wilt deleten?";
    ?>
    <form method="POST" action="#">
        <input type="submit" name="optie" value="Ja" class="cmsbutton">
        <input type="submit" name="optie" value="Nee" class="cmsbutton">
        <input type="hidden" name="userid" value="<?= $_POST['userid'] ?>">
    </form>
    <?php


}

if (isset($_POST['optie']) && ($_POST['optie'] == "Ja")) {
    //als er op delete word geklikt wordt de onderstaande query gedraait.
    $delete = $dbh->prepare("DELETE from user where userid = :userid");
    $delete->bindParam(':userid', $_POST['userid']);
    $delete->execute();
    header("Location: users.php");
    exit;
    //nadat de query klaar is moet de pagina ververst worden.;
}

if (isset($_POST['optie']) && ($_POST['optie'] == "Nee")) {
    echo 'Deleten gecancelled.';
}

    ?>

<!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


