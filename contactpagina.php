<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    </head>
    <body>

        <?php

            include_once('includes/menu.php');

        ?>

        <div class="container container-custom">

            <div class="row">

                <div class="col-xs-12 content">
                    <div class="img-wrapper">

                        <img src="img/rename.png" alt="Samsen Night Logo" class="img-responsive img-logo">

                    </div>

                    <h1>Contact pagina</h1>
                    <p>
                        mocht je een vraag hebben, of wilt gewoon een mail sturen, of je loopt gewoon te kutten ofzo boeit mij het wat stuur me gewoon een mail ik ben echt lonely help! <br> <br>
                        stuur me dan ff een mailtje yo. Vul het onderstaande contact formulier in en misschien stuur ik er nog eentje terug <3

                    </p>

                    <form method="post" action="contactpagina.php">
                        <?php if(isset($_POST["verzenden"])) {?>
                        Naam:  <input type="text" name="naam"  value= "<?php print($_POST["naam"]) ?>"> <br>
                        Email: <input type="text" name="email" value="<?php print($_POST["email"]) ?>"><br>
                        <input type="submit" name="verzenden" value="verzenden">
                    </form>
                    <?php }else{ ?>

                    <form method="post" action="contactpagina.php">

                        Naam:  <input type="text" name="naam"> <br>
                        Email: <input type="text" name="email"><br>
                        <input type="submit" name="verzenden" value="verzenden">
                    </form>
                    <?php } ?>





                </div>

            </div>

        </div>

        <?php

            include_once('includes/footer.php');

        ?>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>