<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 25/11/2016
 * Time: 16:26
 */

session_start();
session_destroy();

header("Location: index.php");