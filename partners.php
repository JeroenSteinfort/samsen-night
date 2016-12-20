<?php

$sql = '
#sql
SELECT partnernaam, link, beschrijving, foto
FROM   partners
';

$sql = $dbh->prepare($sql);
$sql->execute();
$results = $sql->fetchAll();

?>



<div class="row">

    <?php

        foreach ($results as $row) {

            echo '
            <div class="col-xs-12 col-sm-6 partner-wrapper">

                <div class="partner">
      
                    <img class="img-responsive" src="' . $row['foto'] . '" alt="Logo RS Carwash">
                    
                    <h2>' . $row['partnernaam'] . '</h2>
      
                    <hr>
      
                    <p>' . $row['beschrijving'] . '</p>
      
                    <p>Klik <a target="_blank" href="' . $row['link'] . '">hier</a></p>
      
                </div>
      
            </div>
            ';

        }

    ?>

</div>

