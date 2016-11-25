<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 16:04
 */
session_start();
include 'dbh.php';
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];

$sql = "SELECT * FROM user WHERE uid='$uid' AND pwd='$pwd'";
$result = mysqli_query($conn, $sql);

if (!$row = mysqli_fetch_assoc($result)) {
    echo "Usernaam of wachtwoord incorect";
} else {
    $_SESSION['id'] = $row['id'];
}

