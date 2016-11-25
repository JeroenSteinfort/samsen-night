<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="login.php" method="POST">
    <input type="text" name="uid" placeholder="Gebruikersnaam">
    <input type="password" name="pwd" placeholder="Wachtwoord">
    <button type="submit"> Login</button>
</form>

<?php
if (isset($_SESSION['id'])) {
    echo '<img src="don.jpg" alt="wow jij kan inloggen!" />';
} else {
    echo "Jij bent niet ingelogd";
}
?>

<br> <br> <br>

<form action="signup.php" method="POST">
    <input type="text" name="mail" placeholder="Mail adres">
    <input type="text" name="uid" placeholder="Gebruikersnaam">
    <input type="password" name="pwd" placeholder="Wachtwoord">
    <button type="submit"> Aanmelden</button>
</form>

<br> <br> <br>

<form action="loguit.php">
    <button> Uitloggen</button>
</form>

</body>
</html>