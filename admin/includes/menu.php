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

                <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Partners</a></li>
                <li><a href="#">Projecten</a></li>
                <li><a href="#">Contact</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php
                        echo $error;
                        ?> <span class="glyphicon glyphicon-user">  </span> </a>
                    <ul class="dropdown-menu">
                        <?php
                        if(isset($_SESSION['logged_in'])) {
                        ?>
                        <li><a href="loguit.php">Log uit</a></li>
                        <?php } else { ?>
    <form action="#" method="post">
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