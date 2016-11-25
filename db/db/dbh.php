<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 15:47
 */

$conn = mysqli_connect("localhost","root", "usbw","logintest");

if(!$conn) {
    die("Connectie is niet gelukt:".mysqli_connect_error());
}