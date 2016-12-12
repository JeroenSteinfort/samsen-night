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
    echo "<td class=\"cms\">" . "<form action='#' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' value='Wijzig' name='wijzig' class='cmsbutton'>" .  " </input </td> </form>";
    echo "<td class=\"cms\">" . "<form action='#' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' value='Delete' name='delete' class='cmsbutton'>" . " </input>  </td> </form> ";
    echo "<br> </tr>";
    //Hier worden resultaten van de $results geshowed per regel. De delete en wijzig knop krijgen de waarde van de user id. Een input waarde word niet geshowed maar word wel gebruikt.
}
?>
</table>

<?php

/*
if (isset($_POST['wijzig'])) {
    echo "<form method= 'POST' action= '#'>
           <input type= 'text' name= 'vnaam' value= 'Voornaam'> " .
         " <input type= 'text' name= 'tv' value= 'Tussenvoegsel'> " .
         " <input type= 'text' name= 'anaam' value= 'Achternaam'> " .
         " <input type= 'text' name= 'email' value= 'E-mail'> " .
         " <input type= 'text' name= 'foto' value= 'Foto'> " .
         " <input type= 'submit' value= 'Verzend' name= 'finalize' class= 'cmsbutton'> " . " </input> </form> ";
}

if(isset($_POST['finalize'])) {
    $update = $dbh->prepare("UPDATE user SET voornaam = '$_POST['vnaam']', tussenvoegsel = '$_POST['tv']',
                            achternaam = '$_POST['anaam']', email = '$_POST['email']', foto = '$_POST['foto']' WHERE userid = $_POST['userid']");
    $update->execute(array($_POST['userid']));
}*/

if(isset($_POST['delete'])) {
    Echo "Weet u zeker dat u de user met ID = " .  $_POST['userid']  . " wilt deleten?";
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
    echo 'hoi';
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


