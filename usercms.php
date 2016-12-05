<?php

session_start();
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 02/12/2016
 * Time: 11:02
 */
$base_path = $_SERVER['DOCUMENT_ROOT'] . "/samsen-night";
include $base_path . '/includes/dbh.php';
?>
<link rel="stylesheet" type="text/css" href="css\stylesheet.css">
<?php

$userquery = $dbh->prepare("Select * from user");
$userquery->execute();

$results = $userquery->fetchAll();


?>
    <table class="cms">
    <th class="cms"> UserID </th>
    <th class="cms"> Username </th>
    <th class="cms"> Tussenvoegsel </th>
    <th class="cms"> Achternaam </th>
    <th class="cms"> Email </th>
    <th class="cms"> Foto </th>
    <th class="cms"> Rolid </th>
        <th class="cms"> Wijzig </th>
        <th class="cms"> Delete </th>
    <?php
foreach ($results as $row) {
    echo "<tr class=\"cms\"> <td class=\"cms\">" .  $row['userid']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['username']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['tussenvoegsel']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['achternaam']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['email']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['foto']  . " " . "</td>";
    echo "<td class=\"cms\">" .  $row['rolid']  . " " . "</td>";
    echo "<td class=\"cms\">" . "<form action='#' method='post'<button class='cmsbutton' name='wijzig'>" . 'Wijzig' .  " </td> </button> </form>";
    echo "<td class=\"cms\">" . "<form action='#' method='post'<button class='cmsbutton' name='delete'>" . 'Delete' . "  </td> </button> </form>";
    echo "<br> </tr>";
}
?>
</table>
<?php
if(isset($_POST['delete'])) {
    $delete = $dbh->prepare("DELETE * from user where userid = :$userid");
    $delete->bindParam(':userid', $_POST['userid']);
    $delete->execute();
}



