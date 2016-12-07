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

if(!isset($_SESSION['logged_in'])) {

    header("Location: ../index.php");
    exit;

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

        $userquery = $dbh->prepare("Select * from user");
        $userquery->execute();

        $results = $userquery->fetchAll();
        // Bovenste gedeeltje maakt link met CSS en de database connectie

        ?>
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

if(isset($_POST['delete'])) {
    Echo "Weet u zeker dat u de user met ID = " .  $_POST['userid']  . " wilt deleten?";
    ?>
    <form method="POST" action="#">
        <input type="submit" name="optie" value="Ja" class="cmsbutton">
        <input type="submit" name="optie" value="Nee" class="cmsbutton">
        <input type="hidden" name="userid" value="<?= $_POST['userid'] ?>">
    </form>
    <?php
    // form hierboven kiest optie 1 of 2 and stuurt de user id door naaar de inhoud van de forms.


}

if (isset($_POST['optie']) && ($_POST['optie'] == "Ja")) {
    //als er op delete word geklikt word onderstaande query gedraait.
    echo 'hoi';
    $delete = $dbh->prepare("DELETE from user where userid = :userid");
    $delete->bindParam(':userid', $_POST['userid']);
    $delete->execute();
    header("Location: usercms.php");
    exit;
    //na dat de query klaar is moet de pagina ververst worden.;
}

if (isset($_POST['optie']) && ($_POST['optie'] == "Nee")) {
    echo 'Deleten gecancelled.';
}

    ?>

<!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


