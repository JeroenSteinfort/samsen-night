
<?php

session_start();

$base_path = $_SERVER['DOCUMENT_ROOT'] . '\samsen-night';
require_once($base_path . '\includes\dbh.php');

if(!isset($_SESSION['logged_in'])) {

    header("Location: ../index.php");
    exit;

}

$error = "";

if(isset($_GET['p'])){



    $id = $_GET['p'];

    $sql = '
    #sql
    DELETE FROM pagina
    WHERE       paginaid = :id
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':id', $id);
    $sql->execute();

    header("Location: ../admin/pages.php");
    exit;


} else {

    header("Location: ../admin/cpanel.php");
    exit;

}