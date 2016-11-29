<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 28/11/2016
 * Time: 13:28
 */

session_start();
session_destroy();
header('Location: ..\index.php');
exit;
?>

