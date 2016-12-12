<html>
<head>
        <link rel="stylesheet" type="text/css" href="partners.css">
</head>

<body>

<h1>Partner pagina</h1>

<?php
$db_servername = "localhost";
$db_username = "root";
$db_password = "usbw";
$db_name = "samsen-night";

// Connectie maken met database
$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
// Connectie met database checken
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = '
#sql
SELECT partnernaam, beschrijving, link, eigenaar FROM partners
';

$sql = $dbh->prepare($sql);
$sql->execute();

$partners = $sql->fetchAll();

foreach ($partners as $partner){
    echo "<tr class= partner> <td class=partner>" .  $row['partnernaam']  . " " . "</td>";
    echo "<td class= partner>" .  $row['beschrijving']  . " " . "</td>";
    echo "<td class= partner>" .  $row['link']  . " " . "</td>";
}

?>

<table class="partners">
    <tr>
        <th> </th>
        <th>Partner 1</th>
        <th> </th>
    </tr>
    <tr>
        <td><img src="img/rename.png" alt="Samsen"></td>
        <td>Dit bedrijf is gewoon echt heel erg kut want gewoon. Dit bedrijf is gewoon echt heel erg kut want gewoon. Dit bedrijf is gewoon echt heel erg kut want gewoon.</td>
        <td> </td>
    </tr>
    <tr>
        <td> </td>
        <td><a href="http://www.ishetalvrijdag.nl">Link</a></td>
        <td> </td>
    </tr>
</table>

<br><br>

<table class="partners">
    <tr>
        <th> </th>
        <th>Partner 2</th>
        <th> </th>
    </tr>
    <tr>
        <td><img src="img/rename.png" alt="Samsen"></td>
        <td>Dit bedrijf is gewoon een stuk minder kut want.</td>
        <td> </td>
    </tr>
    <tr>
        <td> </td>
        <td><a href="http://www.ishetalvrijdag.nl">Link</a></td>
        <td> </td>
    </tr>
</table>
</body>

</html>