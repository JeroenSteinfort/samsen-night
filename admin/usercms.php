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
if(!isset($_SESSION['logged_in'])) {

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



    <table class="tracker-table">
        <tr>    <th > UserID </th>
    <th > Username </th>
        <th>  Voornaam </th>
    <th> Tussenvoegsel </th>
    <th> Achternaam </th>
    <th> Email </th>
    <th> Foto </th>
    <th> Rolid </th>
        <th> Wijzig </th>
        <th> Delete </th> </tr>
        <?php

        $userquery = $dbh->prepare("Select * from user");
        $userquery->execute();

        $results = $userquery->fetchAll();
        // Bovenste gedeeltje maakt link met CSS en de database connectie

    // bovenste gedeelte zijn headers voor tabel
foreach ($results as $row) {
    echo "<tr> <td>" .  $row['userid']  . " " . "</td>";
    echo "<td>" .  $row['username']  . " " . "</td>";
    echo "<td>" .  $row['voornaam']  . " " . "</td>";
    echo "<td>" .  $row['tussenvoegsel']  . " " . "</td>";
    echo "<td>" .  $row['achternaam']  . " " . "</td>";
    echo "<td>" .  $row['email']  . " " . "</td>";
    echo "<td>" .  $row['foto']  . " " . "</td>";
    echo "<td>" .  $row['rolid']  . " " . "</td>";
    echo "<td>" . "<form action='admin/usercms.php' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' class=\"cms-submit\" value='Wijzig'  name='wijzig' class='cmsbutton'>" .  " </input </td> </form>";
    echo "<td>" . "<form action='admin/usercms.php' method='POST'><input type='text' value='" .  $row['userid']  . "' name='userid' style='display:none;'> <input type='submit' class=\"cms-submit\" value='Delete' name='delete' class='cmsbutton'>" . " </input>  </td> </form> ";
    echo "<br> </tr>";
    //Hier worden resultaten van de $results geshowed per regel. De delete en wijzig knop krijgen de waarde van de user id. Een input waarde word niet geshowed maar word wel gebruikt.
}
?>
</table>
<?php
if(isset($_POST['delete'])) {
    Echo "Weet u zeker dat u de user met ID = " .  $_POST['userid']  . " wilt deleten?";
    ?>
    <form method="POST" action="admin/usercms.php">
        <input type="submit" name="optie" value="Ja" class="cms-submit">
        <input type="submit" name="optie" value="Nee" class="cms-submit">
        <input type="hidden" name="userid" value="<?= $_POST['userid'] ?>">
    </form>
    <?php
    // form hierboven kiest optie 1 of 2 and stuurt de user id door naaar de inhoud van de forms.
}

if (isset($_POST['optie']) && ($_POST['optie'] == "Ja")) {
    //als er op delete word geklikt en optie ja wordt gekozen word de onderste query gedraait.

    $delete = $dbh->prepare("DELETE from user where userid = :userid");
    $delete->bindParam(':userid', $_POST['userid']);
    $delete->execute();
    ?>
    <a href="http://localhost:8080/samsen-night/admin/usercms.php">Refresh de pagina</a> <?php
    exit();
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


