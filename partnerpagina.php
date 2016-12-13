<html>
<head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<h1>Partner pagina</h1>

<?php
//Inlcudes en define base_path
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
require_once($base_path . '\includes\password.php');
require_once($base_path . '\includes\dbh.php');
session_start();

$sql = '
#sql
SELECT partnernaam, beschrijving, link, eigenaar FROM partners
';

$sql = $dbh->prepare($sql);
$sql->execute();

$partners = $sql->fetchAll();

foreach ($partners as $partner){
    echo "<tr class= partner> <td class=partner>" .  $partner['partnernaam']  . " " . "</td>";
    echo "<td class= partner>" .  $partner['beschrijving']  . " " . "</td>";
    echo "<td class= partner>" .  $partner['link']  . " " . "</td>";
}



/*<table class="partners">
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

<html>
*/
?>