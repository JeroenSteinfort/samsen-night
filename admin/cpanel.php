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
                <?php if(isset($_SESSION['rolid'])){
                    //rolid 0 = gebruiker,
                    //rolid 1 = superadmin,
                    //rolid 2 = site beheerder,
                    //rolid 3 = contentbeheerder
                    ?>
                <?php if($_SESSION['rolid'] == 1 || $_SESSION['rolid'] == 3) { ?><li><a href="admin/pages.php">Content beheren</a></li> <?php } ?>
                <?php if($_SESSION['rolid'] == 1 || $_SESSION['rolid'] == 3) { ?><li><a href="admin/partners.php">Partners beheren</a></li> <?php } ?>
                <?php if($_SESSION['rolid'] == 1 || $_SESSION['rolid'] == 2) { ?><li><a href="admin/usercms.php">Users beheren</a></li> <?php } ?>
                <?php if($_SESSION['rolid'] == 1 || $_SESSION['rolid'] == 2) { ?><li><a href="admin/tracker.php">Website tracker resultaten</a></li> <?php } ?>
                <?php } ?>
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