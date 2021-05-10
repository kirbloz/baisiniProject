<?php
    @session_start();
    @include('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());
    if($utente->getPower()<2)
        $authorized = false;
    else
        $authorized = true;
?>
    <div class="wrapper user-area">

        <div class='color-lightb user-nav'>
            <ul>
                <li><a href="areaSuperutente.php">Torna indietro</a></li>
            </ul>
        </div>
   
<?php
    if(!$authorized){
        echo "<p class='centered error'> Non hai i privilegi per accedere a quest'area. </p>";   
    }else{
        echo "</div><div class='wrapper'>";
        /**/
        @require_once('db/databasehandler.inc.php');
    
        //cerco direttamente appoggiandomi all'entità superuser perchè ha un rapporto 1-1 con technician
        $query = "SELECT id_superuser, superuser.id_technician, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power 
            FROM superuser 
            INNER JOIN technician USING(id_technician)
            ORDER BY id_technician ASC;";
    
        //tento la connessione e preparo
        $statement = $connection->prepare($query);
        //invio query con values
        try {
            $statement->execute();
            //var_dump($statement);
        } catch (PDOException $e) {
            //var_dump($statement);
            //echo $e;
            echo "<p class='centered error'>Errore nell'esecuzione della query</p>";
        }
    
        if ($statement->rowCount() < 0) {
            echo "<p class='centered error'>Nessun dipendente trovato</p>";
        }
        echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " dipendenti.<br><br>";
        $arrayTech = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayTech);
        if ($arrayTech == false)
            echo "<p class='centered error'>Errore nell'esecuzione della query</p>";

        /**/
        echo "<table>";
        echo "<thead><tr>";
        echo "<th>Nome</th>
                <th>Cognome</th>
                <th>Genere</th>
                <th>Data di nascita</th>
                <th>Email</th>
                <th>Ufficio</th>
                <th>Supervisore</th>
                <th>Power Level</th>";
        echo "</tr></thead>";

        //per ogni row(dipendente) cerco il relativo superiore
        foreach ($arrayTech as $row) {
            echo "<tr>";
                echo "<td class='gray'>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td class='gray'>" . $row['gender'] . "</td>";
                echo "<td>" . $row['birth_date'] . "</td>";
                echo "<td class='gray'>" . $row['email'] . "</td>";
                echo "<td>" . $row['id_office'] . "</td>";

                //eseguo la ricerca della tupla del capo
                $capo = superuserExists($row['id_supervisor']);
                if(!is_array($capo))
                    echo "<td class='gray'> Unknown </td>";
                else if($capo['firstname'] == $row['firstname'] && $capo['lastname'] == $row['lastname'])
                    echo "<td class='gray'>Nessuno</td>";
                else 
                    echo "<td class='gray'>" . $capo['firstname'] . " " . $capo['lastname'] . "</td>";
            
                echo "<td>" . $row['power'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
   
    echo "fect techs";