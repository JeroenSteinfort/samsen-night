<?php

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

            <ul class="nav navbar-nav">

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
                        <?php
                            if(isset($_SESSION['logged_in'])) {
                        ?>

                                <li><a href="admin/cpanel.php">Control Panel</a></li>
                                <li><a href="admin/pages.php">Content beheren</a></li>
                                <li><a href="admin/partners.php">Partners beheren</a></li>
                                <li><a href="admin/users.php">Users beheren</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="includes/loguit.php">Log uit</a></li>

                        <?php } else { ?>
                        <form action="index.php?p=Home" method="post">
                            <input id="name" name="username" placeholder="username" type="text">
                            <input id="password" name="password" placeholder="**********" type="password">
                            <input name="submit" type="submit" value=" Login ">
                        </form>
                            <li role="separator" class="divider"></li>
                            <li><a class="dropdownlink" href="register.php">Registreren</a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </li>
            </ul>
        </div>

    </div>

</nav>