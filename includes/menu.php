<?php

// gemaakt door Jeroen S en Ethan.

$sql = '
#sql
SELECT paginaid, naam
FROM   pagina
';

$sql = $dbh->prepare($sql);
$sql->execute();

$menuresults = $sql->fetchAll();

?>

<nav class="navbar navbar-default navbar-fixed-top ">

    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav ">

                <!--
                <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Partners</a></li>
                <li><a href="#">Projecten</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Eigenaar</a></li>
                -->

                <?php

                foreach($menuresults as $row){

                    echo '<li ';

                    if(isset($_GET['p']) && $_GET['p'] == $row['naam']){

                        echo 'class="active"';

                    } elseif(!isset($_GET['p']) && $row['naam'] == "Home"){

                        echo 'class="active"';

                    }

                    echo '><a href="index.php?p=' . $row['naam'] . '">' . $row['naam'] . '</a></li>';

                }

                ?>

            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php
                            echo $error;
                        ?>
                        <span class="glyphicon glyphicon-user">  </span> </a>
                        <ul class="dropdown-menu">
                        <?php // Ethan - bovenstaande laat de dropdown menu zien en het icoontje in de hoek.
                            if(isset($_SESSION['logged_in'])) {


                                // hier haal ik alle rechten die de gebruiker heeft op
                                $sql = ' #sql
                                    SELECT r.recht as recht
                                    FROM recht as r
                                    JOIN heeft_recht as hr
                                    ON hr.rechten = r.rechtid
                                    JOIN rol
                                    ON rol.rolid = hr.rolid
                                    WHERE hr.rolid = :rolid 
                                ';
                                $sql = $dbh->prepare($sql);
                                $sql->bindParam(':rolid', $_SESSION['rolid']);
                                $sql->execute();
                                $result = $sql->fetchAll();


                                //alle rechten die de gebruiker worden op deze manier laten zien. controlpanel word bij iedereen laten zien
                                print(" <li><a href=\"admin/cpanel.php\">Control Panel</a></li> ");

                                foreach($result as $row){

                                    if($row['recht'] == "contentbeheren"){
                                        print("<li><a href=\"admin/pages.php\">Content beheren</a></li>");
                                    }
                                    if($row['recht'] == "partnersbeheren"){
                                        print("<li><a href=\"admin/partners.php\">Partners beheren</a></li>");
                                    }
                                    if($row['recht'] == "usersbeheren"){
                                        print("<li><a href=\"admin/usercms.php\">Users beheren</a></li>");
                                    }
                                    if($row['recht'] == "gebruiker"){
                                        print("hier komt de optie om je eigen account aan te passen");
                                    }
                                }

                        ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="includes/loguit.php">Log uit</a></li>
                            <?php }
                            // Ethan - Hieronder bevind de inlog form. Ook vind je hier de knoppen om te registren of wanneer jij je wachtwoord vergeten bent.
                        else { ?>
                        <form action="index.php" method="POST">
                            <input id="name" name="username" placeholder="username" type="text">
                            <input id="password" name="password" placeholder="**********" type="password">
                            <button name="login" type="submit">Login</button>
                        </form>
                            <li role="separator" class="divider"></li>
                            <li><a class="dropdownlink" href="register.php">Registreren</a></li>
                            <li><a class="dropdownlink" href="forgetpass.php">Wachtwoord vergeten?</a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </li>
            </ul>
        </div>

    </div>

</nav>