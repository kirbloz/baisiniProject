<?php
    @session_start();
    @include('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());
    if($utente->getPower()<1)
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
        $query = "SELECT id_user, username, email, firstname, lastname, gender, birth_date, address, city, postal_code 
            FROM user 
            LEFT JOIN customer USING(id_user)
            ORDER BY id_user ASC;";
    
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
        echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " utenti.<br><br>";
        $arrayTech = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayTech);
        if ($arrayTech == false)
            echo "<p class='centered error'>Errore nell'esecuzione della query</p>";

        /**/
        echo "<form method='post' action='fetchSuperuser/deleteUsers.inc.php'>";
        echo "<table>";
        echo "<thead><tr>";
        //valutare di inserire dei tasti per eliminare certi utenti
        echo "
                <th>Username</th>
                <th>Email</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data di nascita</th>
                <th>Genere</th>
                <th>Indirizzo</th>
                <th>Citt&agrave;</th>
                <th>CAP</th>";
        echo "</tr></thead>";

        //per ogni row(dipendente) cerco il relativo superiore
        
        foreach ($arrayTech as $row) {
            echo "<tr>";
                echo "<td class='gray'>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td class='gray'>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td class='gray'>" . $row['birth_date'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td class='gray'>" . $row['address'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td class='gray'>" . $row['postal_code'] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    }
   
    echo "fect users";