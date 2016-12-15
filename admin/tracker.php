<?php

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');
require_once($base_path . '\includes\tracker.php');
date_default_timezone_set("Europe/Paris");
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body>

<?php

include_once($base_path . '/includes/menu.php');

?>

<div class="container container-custom">

    <div class="row">

        <div class="col-xs-12 content">

            <h1>Website tracker Samsen Night</h1>

            <div class="tracker-selector">

                <form action="admin/tracker.php" method="POST">

                    <table class="tracker-selector-table">

                        <tr>

                            <td><label for="begindate">Kies een begin datum: </label></td>

                            <td><input class="date-picker" type="text" value="<?php if(isset($_POST['begindate'])){ echo $_POST['begindate']; } else { echo '00-00-0000'; }   ?>" name="begindate"><br /></td>

                        </tr>

                        <tr>

                            <td><label for="enddate">Kies een eind datum: </label></td>

                            <td><input class="date-picker" type="text" value="<?php if(isset($_POST['enddate'])){ echo $_POST['enddate']; } else { echo '00-00-0000'; }   ?>" name="enddate"><br /></td>

                        </tr>

                        <tr>

                            <td></td>

                            <td><input class="cms-submit" type="submit" name="submit"></td>

                        </tr>

                    </table>

                </form>

                <hr />

                <form action="admin/tracker.php" method="POST">

                    <table class="tracker-selector-table">

                        <tr>

                            <td><label for="page">Kies een Pagina: </label></td>

                            <td>

                                <select name="page">

                                    <option value="None">Kies een pagina</option>

                                    <?php

                                    $page = "";

                                    if(isset($_POST['page'])){

                                        $page = $_POST['page'];

                                    } else {

                                        $page = "None";

                                    }

                                    getAllPagesDropdown($dbh, $page);

                                    ?>

                                </select>

                            </td>

                        </tr>

                        <tr>

                            <td></td>

                            <td><input class="cms-submit" type="submit" name="submit"></td>

                        </tr>

                    </table>

                </form>

            </div>

            <?php



                if(isset($_POST['begindate']) && isset($_POST['enddate'])){

                    echo '<p>Aantal bezoekers per pagina per dag</p>';

                    getAllVisitorsByDate($dbh, $_POST['begindate'], $_POST['enddate']);

                } elseif(isset($_POST['page'])){

                    getAllVisitorsByPage($dbh, $page);

                } else {

                    echo '<p>Alle bezoekers:</p>';

                    getAllVisitors($dbh);

                }


            ?>

        </div>

    </div>

</div>

<?php

include_once($base_path . '/includes/footer.php');

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $( document ).ready( function () {

        $( ".date-picker" ).datepicker({

            dateFormat: 'dd-mm-yy'

        });

    } );

</script>

</body>
</html>