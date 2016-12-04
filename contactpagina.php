<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
                    <h1>Contact pagina</h1>
                    <p>
                        mocht je een vraag hebben, of wilt gewoon een mail sturen, of je loopt gewoon te kutten ofzo boeit mij het wat stuur me gewoon een mail ik ben echt lonely help! <br> <br>
                        stuur me dan ff een mailtje yo. Vul het onderstaande contact formulier in en misschien stuur ik er nog eentje terug <3

                    </p>

                    <form method="post" action="index.php">
                        <?php if(isset($_POST["verzenden"])) {?>
                        Naam:  <input type="text" name="naam"  value= "<?php print($_POST["naam"]) ?>"> <br>
                        Email: <input type="text" name="email" value="<?php print($_POST["email"]) ?>"><br>
                        <input type="submit" name="verzenden" value="verzenden">
                    </form>
                    <?php }else{ ?>

                    <form method="post" action="index.php">
                        <table>
                        <tr>
                            <td>Voornaam:</td> <td><input type="text" name="voornaam"></td></tr><tr>
                            <td>Tussenvoegsel:</td> <td><input type="text" name="tussen"></td></tr><tr>
                            <td>Achternaam:</td> <td><input type="text" name="achternaam"></td></tr><tr>
                            <td>bedrijfsnaam:</td><td><input type="text" name="bedrijfsnaam"></td></tr><tr>
                            <td>Onderwerp:</td><td><input type="text" name="onderwerp"></td></tr><tr>
                            <td>Email: </td><td><input type="text" name="email"></td></tr>
                        
                        

                        
                        </table>
                        
                        <input type="submit" name="verzenden" value="verzenden">
                    </form>
                    <?php } ?>
                    

                    
    </body>
</html>
