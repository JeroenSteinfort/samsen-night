<?php

//Een nieuwe bezoeker aanmaken in database (aangeroepen voor elke pagina die geladen wordt)
function newVisitor($dbh, $page){

    if(isset($_SESSION['user_id'])){

        $userid = $_SESSION['user_id'];

    } else {

        $userid = NULL;

    }

    $ipadres = $_SERVER['REMOTE_ADDR'];

    $sql = '
    #sql
    INSERT INTO `bezoeker`
    (`pagina`, `userid`, `ipadres`)
    VALUES
    (:pagina,  :userid,  :ipadres)
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':pagina',   $page);
    $sql->bindParam(':userid',   $userid);
    $sql->bindParam(':ipadres',  $ipadres);
    $sql->execute();

}

//Alle bezoekers uit de database halen
function getAllVisitors($dbh){

    $sql = '
    #sql
    SELECT    ipadres, pagina, DATE_FORMAT(tijddatum, "%d-%c-%Y %T") AS datetime, u.username AS username
    FROM      bezoeker AS b
    LEFT JOIN user     AS u
    ON        u.userid = b.userid
    ORDER BY  tijddatum DESC
    ';
    $sql = $dbh->prepare($sql);
    $sql->execute();

    $results = $sql->fetchAll();

    echo '<table class="tracker-table"><tr><th>ipadres:</th><th>pagina:</th><th>Datum en Tijd:</th><th>Username:</th></tr>';

    foreach($results as $row){

        if($row['username'] == NULL){

            $row['username'] = "n.v.t.";

        }

        echo '<tr><td>' . $row['ipadres'] . '</td><td>' . $row['pagina'] . '</td><td>' . $row['datetime'] . '</td><td>' . $row['username'] . '</td></tr>';

    }

    echo '</table>';

}

//Alle bezoeker tussen bepaalde datums uit database halen
function getAllVisitorsByDate($dbh, $begindate, $enddate){

    $sql = '
    #sql
    SELECT    ipadres, pagina, DATE_FORMAT(tijddatum, "%d-%c-%Y") AS datetime, u.username AS username, COUNT(*) AS aantal
    FROM      bezoeker AS b
    LEFT JOIN user     AS u
    ON        u.userid = b.userid
    WHERE     DATE_FORMAT(tijddatum, "%d-%c-%Y") BETWEEN :begindate AND :enddate
    GROUP BY  DATE(tijddatum), pagina
    ORDER BY  tijddatum DESC
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':begindate', $begindate);
    $sql->bindParam(':enddate',   $enddate);
    $sql->execute();

    $results = $sql->fetchAll();

    echo '<a href="admin/tracker.php"><< Terug</a>';

    echo '<table class="tracker-table"><tr><th>Pagina:</th><th>Datum:</th><th>Aantal:</th></tr>';

    foreach($results as $row){

        if($row['username'] == NULL){

            $row['username'] = "n.v.t.";

        }

        echo '<tr><td>' . $row['pagina'] . '</td><td>' . $row['datetime'] . '</td><td>' . $row['aantal'] . '</td></tr>';

    }

    echo '</table>';

}

//Alle bezoeker tussen bepaalde datums uit database halen
function getAllVisitorsByPage($dbh, $page){

    $sql = '
    #sql
    SELECT    ipadres, pagina, DATE_FORMAT(tijddatum, "%d-%c-%Y %T") AS datetime, u.username AS username
    FROM      bezoeker AS b
    LEFT JOIN user     AS u
    ON        u.userid = b.userid
    WHERE     pagina   = :pagina
    ORDER BY  tijddatum DESC
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':pagina', $page);
    $sql->execute();

    $results = $sql->fetchAll();

    echo '<table class="tracker-table"><tr><th>ipadres:</th><th>pagina:</th><th>Datum en Tijd:</th><th>Username:</th></tr>';

    foreach($results as $row){

        if($row['username'] == NULL){

            $row['username'] = "n.v.t.";

        }

        echo '<tr><td>' . $row['ipadres'] . '</td><td>' . $row['pagina'] . '</td><td>' . $row['datetime'] . '</td><td>' . $row['username'] . '</td></tr>';

    }

    $sql = '
    #sql
    SELECT COUNT(bezoekerid) AS Totaal
    FROM      bezoeker AS b
    LEFT JOIN user     AS u
    ON        u.userid = b.userid
    WHERE     pagina   = :pagina
    ORDER BY  tijddatum DESC
    ';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':pagina', $page);
    $sql->execute();

    $result = $sql->fetch();

    echo '<tr><td>Totaal aantal bezoekers: ' . $result['Totaal'] . '</td><td></td><td></td><td></td></tr>';

    echo '</table>';

}

function getAllPagesDropdown($dbh, $page){

    $sql = '
    #sql
    SELECT paginaid, naam
    FROM   pagina
    ';
    $sql = $dbh->prepare($sql);
    $sql->execute();

    $results = $sql->fetchAll();

    foreach($results as $row){

        echo '<option ';

        if($page == $row['naam']){

            echo 'selected';

        }

        echo ' value="' . $row['naam'] . '">' . $row['naam'] . '</option>';

    }

}