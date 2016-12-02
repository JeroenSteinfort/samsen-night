<?php

$username = "u339047138_root";
$password = "WTthQWQZs6pQNA";

try {
    $dbh = new PDO("mysql:host=sql1.hostinger.nl;dbname=u339047138_db", $username, $password);
    // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
   echo "Connection failed: " . $e->getMessage();
}
?>