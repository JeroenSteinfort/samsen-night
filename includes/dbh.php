<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 15:47
 */

$servername = "localhost";
$username = "root";
$password = "usbw";

try {
    $dbh = new PDO("mysql:host=localhost:3307;dbname=samsen-night", $username, $password);
    // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
   // echo "Connection failed: " . $e->getMessage();
}
?>