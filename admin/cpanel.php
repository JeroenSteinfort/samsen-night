<?php
session_start();
if(!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
}

    echo 'test';

?>
<form action="includes\loguit.php" method="post">
    <input name="submit" type="submit" value="Loguit ">
</form>