<?php

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

            <h1>CMS Samsen Night</h1>

            <p>Dit is het CMS van Samsen Night. Kies een optie:</p>

            <ul>
                <?php

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

                    foreach($result as $row) {

                        if ($row['recht'] == "contentbeheren") {
                            print("<li><a href=\"admin/pages.php\">Content beheren</a></li>");
                        }
                        if ($row['recht'] == "partnersbeheren") {
                            print("<li><a href=\"admin/partners.php\">Partners beheren</a></li>");
                        }
                        if ($row['recht'] == "usersbeheren") {
                            print("<li><a href=\"admin/usercms.php\">Users beheren</a></li>");
                        }
                        if($row['recht'] == "tracksysteem"){
                            print("<li><a href=\"admin/tracker.php\">Website tracker resultaten</a></li>");
                        }
                        if($row['recht'] == "gebruiker"){
                            print("hier komt de optie om je eigen account aan te passen");
                        }
                    }
                    ?>

            </ul>

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