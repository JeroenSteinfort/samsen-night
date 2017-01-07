<?php

//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . '\samsen-night';
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');

session_start();

//Rechten en rollen bepalen van gebruiker
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


//Als de user niet ingelogd is of de rechten niet heeft terugsturen naar index.php
if(!isset($_SESSION['logged_in']) || $contentbeheren==false) {

    header("Location: ../index.php");
    exit;

}

$error = "";

//Deze code wordt uitgevoerd als een pagina gewijzigd is
if(isset($_POST['editpage'])){

    $content   = $_POST['editor1'];
    $paginaid  = $_GET['p'];

    //Update de pagina in database
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

//Als er een pagina wordt toegevoegd
if(isset($_POST['addpage'])){

    $naam = $_POST['paginanaam'];

    //Pagina toevoegen
    $sql = "
    #sql
    INSERT INTO pagina  (naam)
    VALUES             (:naam)
    ";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':naam', $naam);
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

                //Alle pagina's ophalen uit database
                $sql = "
                #sql
                SELECT paginaid, naam
                FROM   pagina
                ";
                $sql = $dbh->prepare($sql);
                $sql->execute();

                $paginaresults = $sql->fetchAll();

                //Alle pagina namen in een tabel zetten
                //Met een wijzig en verwijder optie
                echo '<table class="cms-page-list">
                        ';

                foreach ($paginaresults as $row){

                    echo '<tr><td>' . $row['naam'] . '</td><td><a href="admin/pages.php?p=' . $row['paginaid'] . '"><span class="glyphicon glyphicon-pencil"></span></a></td><td><a href="includes/deletepage.php?p=' . $row['paginaid'] . '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';

                }

                //Code om nieuwe pagina te maken
                echo '<tr><td>Nieuwe pagina maken:<br />
                      <form method="POST" action="admin/pages.php">
                      <input type="text" name="paginanaam" />
                      <button name="addpage" type="submit" class="plus-button"><span class="glyphicon glyphicon-plus"></span></button>
                      </form></td></tr>';

                echo '</table>';

                //Deze code wordt uitgevoerd als er een pagina gewijzigd moet worden
                if(isset($_GET['p'])){

                    $paginaid = $_GET['p'];

                    //Haal content en naam op uit database
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

                    echo '<form method="POST" action="admin/pages.php?p=' . $paginaid . '"><textarea id="editor1" name="editor1">' . $contentresult[2] . '</textarea><br /><input class="cms-submit" type="submit" name="editpage" value="submit" /></form>';

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