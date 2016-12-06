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
SELECT content
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

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="img\wiggers.jpg" alt="Chania">
            </div>

            <div class="item">
                <img src="img\wiggers.jpg" alt="Chania">
            </div>

            <div class="item">
                <img src="img\wiggers.jpg" alt="Flower">
            </div>

            <div class="item">
                <img src="img_flower2.jpg" alt="Flower">
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
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