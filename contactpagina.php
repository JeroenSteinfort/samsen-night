<?php

//wanneer iets is ingevuld, maar een bepaalde veld is niet ingevuld
//terwijl die wel verplicht was, zet deze het ingevulde veld gewoon terug.
function check_fill($input) {
    if (isset($_POST[$input]) && !empty($_POST[$input])) {
        return $_POST[$input];
    }
    return false;
}


//kijken of een veld verplicht is. Zo wel, en niet ingevuld, word de naam rood.
function required($input) {
    if (!isset($_POST[$input]) || empty($_POST[$input])) {

        return ' style="color:red;"';

    }
}


?>

                        <?php if(isset($_POST["verzenden"]) 
                                && 
                                (empty($_POST['voornaam']) || 
                                empty($_POST['achternaam']) || empty($_POST['onderwerp']) || empty($_POST['email']) || empty($_POST['bericht']))) {?>
                    <form method="post" action="contactpagina.php" id="contactpagina">
                        
                        <table>
                        <tr>
                            <td <?php print(required("voornaam")) ?>>Voornaam:</td> <td><input type="text" name="voornaam" value= "<?php print(check_fill("voornaam")) ?>"></td></tr><tr>
                            <td>Tussenvoegsel:</td> <td><input type="text" name="tussen" value= "<?php print($_POST["tussen"]) ?>"></td></tr><tr>
                            <td <?php print(required("achternaam")) ?>>Achternaam:</td> <td><input type="text" name="achternaam" value= "<?php print($_POST["achternaam"]) ?>"></td></tr><tr>
                            <td>bedrijfsnaam:</td><td><input type="text" name="bedrijfsnaam" value= "<?php print($_POST["bedrijfsnaam"]) ?>"></td></tr><tr>
                            <td <?php print(required("onderwerp")) ?>>Onderwerp:</td><td><input type="text" name="onderwerp" value= "<?php print($_POST["onderwerp"]) ?>"></td></tr><tr>
                            <td <?php print(required("email")) ?>>Email: </td><td><input type="text" name="email" value= "<?php print($_POST["email"]) ?>"></td>
                        </tr>
                        <tr><td<?php print(required("bericht")) ?>>Bericht:</td></tr> <br>
                        </table>
                        
                        <textarea  id="contactpagina" form="contactpagina" name="bericht" rows="15" cols="50" wrap="soft"><?php print($_POST["bericht"]) ?></textarea><br>
                        <input type="submit" name="verzenden" value="verzenden"> 
                        <br>
                        <h3 style="color: red; text-align: center;">rode velden zijn verplicht</h3>
                    </form>
                    <?php }elseif(!isset($_POST['verzenden'])){ ?>

                    <form method="post" action="contactpagina.php" id="contactpagina">
                        <table>
                        <tr>
                            <td>Voornaam:</td> <td><input type="text" name="voornaam"></td></tr><tr>
                            <td>Tussenvoegsel:</td> <td><input type="text" name="tussen"></td></tr><tr>
                            <td>Achternaam:</td> <td><input type="text" name="achternaam"></td></tr><tr>
                            <td>bedrijfsnaam:</td><td><input type="text" name="bedrijfsnaam"></td></tr><tr>
                            <td>Onderwerp:</td><td><input type="text" name="onderwerp"></td></tr><tr>
                            <td>Email: </td><td><input type="email" name="email"></td></tr>
                        </tr>
                        </table>
                        Bericht: <br>
                        <textarea id="contactpagina" name="bericht" rows="15" cols="50" wrap="soft"></textarea><br>
                        <input type="submit" name="verzenden" value="verzenden">

                        
                    </form>
                    <?php } 
                    elseif(isset($_POST['verzenden'])&& !empty($_POST['voornaam']) && !empty($_POST['achternaam']) && !empty($_POST['email']) && !empty($_POST['onderwerp']) && !empty($_POST['bericht'])){
                        print("<h3>" . "Bericht is verstuurd. U ontvangt zo spoedig mogelijk een bericht." . "</h3>");
                        
                        $query = 'INSERT INTO formulier
                                (voornaam, tussenvoegsel,  achternaam, email, bedrijfsnaam, onderwerp, bericht)
                                VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :bedrijfsnaam, :onderwerp, :bericht)
                                ';
                        
                        $query= $dbh->prepare($query);
                        $query->bindParam(':voornaam', $_POST['voornaam']);
                        $query->bindParam(':tussenvoegsel', $_POST['tussen']);
                        $query->bindParam(':achternaam', $_POST['achternaam']);
                        $query->bindParam(':email', $_POST['email']);
                        $query->bindParam(':bedrijfsnaam', $_POST['bedrijfsnaam']);
                        $query->bindParam(':onderwerp', $_POST['onderwerp']);
                        $query->bindParam(':bericht', $_POST['bericht']);
                        $query->execute();
                    
                    $msg = "";
                    if(!empty($_POST['tussenvoegsel']) && !empty($_POST['bedrijfsnaam'])){
                        $msg = $_POST['voornaam'] . " " . $_POST['tussenvoegsel'] . " " . $_POST['achternaam'] . "<br>"
                                . $_POST['bedrijfsnaam'] . "<br>" . 
                                $_POST['email'] . "<br>" . 
                                $_POST['onderwerp'] . "<br>" . 
                                $_POST['bericht'];
                        mail("mathijs.breuker@hotmail.com", $_POST['onderwerp'], $msg);
                    }elseif(empty($_POST['tussenvoegsel']) && !empty($_POST['bedrijfsnaam'])){
                        $msg = $_POST['voornaam'] . " " . $_POST['achternaam'] . "<br>"
                                . $_POST['bedrijfsnaam'] . "<br>" . 
                                $_POST['email'] . "<br>" . 
                                $_POST['onderwerp'] . "<br>" . 
                                $_POST['bericht'];
                        mail("mathijs.breuker@hotmail.com", $_POST['onderwerp'], $msg);
                    }elseif(!empty($_POST['tussenvoegsel']) && empty($_POST['bedrijfsnaam'])){
                        $msg = $_POST['voornaam'] . " " . $_POST['tussenvoegsel'] . " " . $_POST['achternaam'] . "<br>" .
                                $_POST['email'] . "<br>" . 
                                $_POST['onderwerp'] . "<br>" . 
                                $_POST['bericht'];
                        mail("mathijs.breuker@hotmail.com", $_POST['onderwerp'], $msg);
                    }elseif(empty($_POST['tussenvoegsel']) && empty($_POST['bedrijfsnaam'])){
                        $msg = $_POST['voornaam'] . " " . $_POST['achternaam'] . "<br>" .
                                $_POST['email'] . "<br>" . 
                                $_POST['onderwerp'] . "<br>" . 
                                $_POST['bericht'];
                        mail("mathijs.breuker@hotmail.com", $_POST['onderwerp'], $msg);
                    }
                    }

                    
?>
