<?php

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . '\samsen-night';
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');

session_start();

if(!isset($_SESSION['logged_in'])) {

    header("Location: ../index.php");
    exit;

}

$error = "";

if(isset($_POST['submit'])){

    $content   = $_POST['editor1'];
    $paginaid  = $_GET['p'];

    $sql = "
    #sql
    UPDATE pagina
    SET    content  = :content
    WHERE  paginaid = :paginaid
    ";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':content',  $content);
    $sql->bindParam(':paginaid', $paginaid);
    $sql->execute();

}

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

            <h1>CMS Samsen Night - Content beheren</h1>

            <p>In dit gedeelte van het CMS kan de content aangepast worden, kies een pagina:</p>

                <?php

                echo '<ul class="cms-page-list">';

                $sql = "
                #sql
                SELECT paginaid, naam
                FROM   pagina
                ";
                $sql = $dbh->prepare($sql);
                $sql->execute();

                $paginaresults = $sql->fetchAll();

                foreach ($paginaresults as $row){

                    echo '<li><a href="admin/pages.php?p=' . $row['paginaid'] . '">' . $row['naam'] . '</a></li>';

                }

                echo '<li>Nieuwe pagina maken: 
                    <form method="POST" action="#">
                    <input type="text" name="paginanaam" />
                    <button class="plus-button" type="submit"><span class="glyphicon glyphicon-plus"></span></button>
                    </form>
                    </li>';

                echo '</ul>';

                if(isset($_GET['p'])){

                    $paginaid = $_GET['p'];

                    $sql = '
                    #sql
                    SELECT paginaid, naam, content
                    FROM   pagina
                    WHERE  paginaid = :paginaid
                    LIMIT  1
                    ';
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(':paginaid', $paginaid);
                    $sql->execute();

                    $contentresult = $sql->fetch();

                    echo '<form method="POST" action="admin/pages.php?p=' . $paginaid . '"><textarea id="editor1" name="editor1">' . $contentresult[2] . '</textarea><br /><input class="cms-submit" type="submit" name="submit" value="submit" /></form>';

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

<script src="admin/ckeditor/ckeditor.js"></script>

<script>

    CKEDITOR.replace( 'editor1' );

</script>

</body>
</html>