<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 15:47
 */
session_start();
include 'dbh.php';
$mail = $_POST['mail'];
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];

$sql = "INSERT INTO user (mail, uid, pwd) 
VALUES ('$mail', '$uid', '$pwd')";
$result = mysqli_query($conn, $sql);

header("Location: index.php");