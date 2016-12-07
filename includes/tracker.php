<?php

//Een nieuwe bezoeker aanmaken in database (aangeroepen voor elke pagina die geladen wordt)
function newVisitor($page){

    $ipadress = $_SERVER['REMOTE_ADDR'];

    $sql = '
    #sql
    INSERT INTO `bezoeker`
    (`ipadress`, `pagina`)
    VALUES
    (:ipadress, :pagina)
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':ipadress', $ipadress);
    $sql->bindParam(':pagina',   $pagina);
    $sql->execute();

}

echo $_SERVER['REMOTE_ADDR'];