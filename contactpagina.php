<?php

//kijken of een veld verplicht is. Zo wel, en niet ingevuld, word de naam rood.
function required($input) {
    if (!isset($_POST[$input]) || empty($_POST[$input])) {

        return ' style="color:red;"';

    }
}


?>
<!--                            wanneer er op verzennden is gedrukt, en een van de verplichte velden is nog niet ingevuld, dan springt hij naar deze pagina, en laat hij de verplichte velden, wat niet is ingevuld, als rood zien
                                maar het gene wat wel is ingevuld, neemt hij wel mee van het vorige formulier. -->
                        <?php if(isset($_POST["verzenden"]) 
                                && 
                                (empty($_POST['voornaam']) || 
                                empty($_POST['achternaam']) || empty($_POST['onderwerp']) || empty($_POST['email']) || empty($_POST['bericht']))) {?>
                    <form method="post" action="index.php?p=Contact" id="contactpagina">
                        
                        <table>
                            <tr>
                                <td <?php print(required("voornaam")) ?>>Voornaam:</td> <td><input type="text" class="form-control" name="voornaam" value= "<?php print($_POST["voornaam"]) ?>"></td>
                            </tr>
                            <tr>
                                <td>Tussenvoegsel:</td>
                                <td><input type="text" name="tussen" class="form-control" value= "<?php print($_POST["tussen"]) ?>"></td>
                            </tr>
                            <tr>
                                <td <?php print(required("achternaam")) ?>>Achternaam:</td>
                                <td><input type="text" name="achternaam" class="form-control" value= "<?php print($_POST["achternaam"]) ?>"></td>
                            </tr>
                            <tr>
                                <td>bedrijfsnaam:</td>
                                <td><input type="text" name="bedrijfsnaam" class="form-control" value= "<?php print($_POST["bedrijfsnaam"]) ?>"></td>
                            </tr>
                            <tr>
                                <td <?php print(required("onderwerp")) ?>>Onderwerp:</td>
                                <td><input type="text" name="onderwerp" class="form-control" value= "<?php print($_POST["onderwerp"]) ?>"></td>
                            </tr>
                            <tr>
                                <td <?php print(required("email")) ?>>Email: </td>
                                <td><input type="text" name="email" class="form-control" value= "<?php print($_POST["email"]) ?>"></td>
                            </tr>
                            <tr>
                                <td<?php print(required("bericht")) ?>>Bericht:</td>
                            </tr> <br>
                        </table>
                        
                        <textarea  id="contactpagina" form="contactpagina"  class="form-control" name="bericht" rows="15" ' style="width:100%;"' wrap="soft"><?php print($_POST["bericht"]) ?></textarea><br>
                        <input type="submit"  name="verzenden" value="verzenden">
                        <br>
                        <h3 style="color: red; text-align: center;">rode velden zijn verplicht</h3>
                    </form>



<!--                            als er nog niet op verzenden is gedrukt gaar hij hier heen-->
                    <?php }elseif(!isset($_POST['verzenden'])){ ?>

                    <form method="post" action="index.php?p=Contact" id="contactpagina">
                        <table>
                            <tr>
                                <td>Voornaam:</td>
                                <td><input type="text" class="form-control" name="voornaam"></td>
                            </tr>
                            <tr>
                                <td>Tussenvoegsel:</td>
                                <td><input type="text" class="form-control" name="tussen"></td>
                            </tr>
                            <tr>
                                <td>Achternaam:</td>
                                <td><input type="text" class="form-control" name="achternaam">
                                </td>
                            </tr>
                            <tr>
                                <td>bedrijfsnaam:</td>
                                <td><input type="text" class="form-control" name="bedrijfsnaam"></td>
                            </tr>
                            <tr>
                                <td>Onderwerp:</td>
                                <td><input type="text"  class="form-control"name="onderwerp"></td>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td><input type="email" class="form-control" name="email"></td>
                            </tr>
                            </tr>
                        </table>
                        Bericht: <br>
                        <textarea id="contactpagina" class="form-control" name="bericht" rows="15" ' style="width:100%;"' wrap="soft"></textarea><br>
                        <input type="submit" class="cms-submit" name="verzenden" value="verzenden">

                        
                    </form>
                    <?php }
                    //als je op verzenden hebt gedrukt, en al het verplichte is ingevuld, dan gaat hij verder
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
                        $naar = "mathijs.breuker@hotmail.com";
                        $van = "From: noreply@samsennight.com";
                        $ingevuld_door = $_POST["email"];
                        $antwoord = "Uw mail is ontvangen. U ontvangt zo spoedig mogelijk een reactie.";

                        //mail sturen!


                        //bij elk niet-verplicht punt kijken of het wel of niet is ingevuld.
                        if(!empty($_POST['tussenvoegsel']) && !empty($_POST['bedrijfsnaam'])){
                            $msg = $_POST['voornaam'] . " " . $_POST['tussenvoegsel'] . " " . $_POST['achternaam'] . "<br>"
                                . $_POST['bedrijfsnaam'] . "<br>" .
                                $_POST['email'] . "<br>" .
                                $_POST['onderwerp'] . "<br>" .
                                $_POST['bericht'];
                            mail($naar, $_POST['onderwerp'], $msg, $van);
                            mail($ingevuld_door, $antwoord, $antwoord, $van);
                        }elseif(empty($_POST['tussenvoegsel']) && !empty($_POST['bedrijfsnaam'])){
                            $msg = $_POST['voornaam'] . " " . $_POST['achternaam'] . "<br>"
                                . $_POST['bedrijfsnaam'] . "<br>" .
                                $_POST['email'] . "<br>" .
                                $_POST['onderwerp'] . "<br>" .
                                $_POST['bericht'];
                            mail($naar, $_POST['onderwerp'], $msg, $van);
                            mail($ingevuld_door, $antwoord, $antwoord, $van);
                        }elseif(!empty($_POST['tussenvoegsel']) && empty($_POST['bedrijfsnaam'])){
                            $msg = $_POST['voornaam'] . " " . $_POST['tussenvoegsel'] . " " . $_POST['achternaam'] . "<br>" .
                                $_POST['email'] . "<br>" .
                                $_POST['onderwerp'] . "<br>" .
                                $_POST['bericht'];
                            mail($naar, $_POST['onderwerp'], $msg, $van);
                            mail($ingevuld_door, $antwoord, $antwoord, $van);
                        }elseif(empty($_POST['tussenvoegsel']) && empty($_POST['bedrijfsnaam'])){
                            $msg = $_POST['voornaam'] . " " . $_POST['achternaam'] . "<br>" .
                                $_POST['email'] . "<br>" .
                                $_POST['onderwerp'] . "<br>" .
                                $_POST['bericht'];
                            mail($naar, $_POST['onderwerp'], $msg, $van);
                            mail($ingevuld_door, $antwoord, $antwoord, $van);
                        }
                    }

                    //er worden twee mails gestuurd. Een mail naar Samsen Night, en een naar degene die het contactformulier heeft ingevuld.

                    
?>
