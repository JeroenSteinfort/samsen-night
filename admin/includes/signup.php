<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 15:47
 */
session_start();
include 'dbh.php';
include'password.php';
$username = $_POST['username'];
$voornaam = $_POST['voornaam'];
$tussenvoegsel = $_POST['tussenvoegsel'];
$achternaam = $_POST['achternaam'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$email = $_POST['email'];
$foto = $_POST['foto'];

$sql = "SELECT userid FROM user where username = :username OR email = :email limit 1";

$sql = $dbh->prepare($sql);
$sql->bindParam(":username",$username);
$sql->bindParam(":email",$email);
$sql-> execute();
$results = $sql ->fetch();
if ($results > 0) {
    echo "Username of Email is al ingebruik.";
} else {

$sql = "INSERT INTO user (username, voornaam, tussenvoegsel, achternaam, password, email, foto) 
VALUES (:username, :voornaam, :tussenvoegsel, :achternaam, :password, :email, :foto)";
$sql = $dbh->prepare($sql);

$sql->bindParam(":username",$username);
$sql->bindParam(":voornaam",$voornaam);
$sql->bindParam(":tussenvoegsel",$tussenvoegsel);
$sql->bindParam(":achternaam",$achternaam);
$sql->bindParam(":password",$password);
$sql->bindParam(":email",$email);
$sql->bindParam(":foto",$foto);
$sql-> execute();

header("Location: ../index.php");
}