<?php

$username = "u339047138_root";
$password = "UMORFBNfQi4Yt4ikr2";

try {
    $dbh = new PDO("mysql:host=mysql.hostinger.nl;dbname=u339047138_db", $username, $password);
    // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
   echo "Connection failed: " . $e->getMessage();
}
?>