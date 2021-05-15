<?php
    @require_once('php/session.inc.php');
    @session_start();
    if(!checkActiveSuper())
        header('location:../superlogin.php?error=nosession'); //session
    @require_once('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());

    echo "<br><br>";
    echo "superuser loggato: " . $utente->getLastname();
    echo "<br><br>";
    if(!isset($_GET))
    header('location:../areaSuperutente.php');
    
    if(isset($_GET['matricola'])){
        $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :matricola;";
        $values[':matricola'] = $utente->getMatricola();
        //uso $utente->getMatricola perchè così sono sicuro che visualizzo l'utente loggato

        global $connection;
        $statement = $connection->prepare($query);
        
        try{
            $statement->execute($values);
            
        }catch(PDOException $e){
            echo "<p class='centered error'>Nessun dipendente trovato</p>";
            echo $e;
            //die();
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);
        else
            echo "<p class='centered error'>Nessun dipendente trovato</p>";
        //var_dump($statement);

        echo "<table class='single'>";
        echo "  
        <tr><td>ID</td><td>" . $statement['id_technician'] . "</td></tr>
        <tr><td>Nome</td><td class='gray'>" . $statement['firstname'] . "</td></tr>
        <tr><td>Cognome</td><td>" . $statement['lastname'] . "</td></tr>
        <tr><td>Email</td><td class='gray'>" . $statement['email'] . "</td></tr>
        <tr><td>Data di nascita</td><td>" . $statement['birth_date'] . "</td></tr>
        <tr><td>Genere</td><td class='gray'>" . $statement['gender'] . "</td></tr>";

        //eseguo la ricerca della tupla del capo
        $capo = superuserExists($statement['id_supervisor']);
        if(!is_array($capo))
            echo "<tr><td>Supervisore</td><td> Unknown </td></tr>";
        else if($capo['firstname'] == $statement['firstname'] && $capo['lastname'] == $statement['lastname'])
            echo "<tr><td>Supervisore</td><td>Nessuno</td></tr>";
        else 
            echo "<tr><td>Supervisore</td><td>" . $capo['firstname'] . " " . $capo['lastname'] . "</td></tr>";

        //switch per indicare il ruolo del tecnico all'interno dell'azienda
        switch($statement['power']){
            case 0:
                $string ="Dipendente";
                break;
            case 1:
                $string ="Supervisore";
                break;
            case 2:
                $string ="Capo Ufficio";
                break;
            default:
                $string ="Unknown";
        }

        echo "<tr><td>Power Level</td><td class='gray'>" . $string . "</td></tr>
            <tr><td>Ufficio</td><td>" . $statement['id_office'] . "</td></tr>";
        echo "</table>";  
/*
    aggiungere query per visualizzare i lavori del tecnico
    i suoi sottoposti
    il suo superiore
    la sua paga
    varie ed eventuali

    OUTPUT A VIDEO DEI SOTTOPOSTI E EVENTUALE SUPERIORE
*/

        //controllo ulteriore che sia l'utente effettivo che richiede e non una modifica dell'url
        if($_GET['self']){
            
            //capoufficio e supervisore, stampo i dipendenti
            if($utente->getPower() > 0 ){ 
                echo "<br><div class='sottoposti'>";
                //vado a ricercare tutti i tecnici sottoposti a questo
                $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_supervisor = :matricola;";
                $values[':matricola'] = $utente->getMatricola();
                //uso $utente->getMatricola perchè così sono sicuro che visualizzo l'utente loggato

                global $connection;
                $statement = $connection->prepare($query);
                try{
                    $statement->execute($values);
                }catch(PDOException $e){
                    echo "<p class='centered error'>Nessun sottoposto trovato</p>";
                    //echo $e;
                    //die();
                }

                //se trovo sottoposti stampo
                if($statement->rowCount() > 0){
                    $arrayTech=$statement->fetchAll(PDO::FETCH_ASSOC);
                    echo "<form method='post' action=''>";
                    echo "<table class='multi'>";
                    echo "<thead><tr>";
                    echo "  <th> </th>
                        <th>Nome</th>
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
                            echo "<td><input type='checkbox' name='id_techs[]' value='" .  $row['id_technician'] . "'></td>";
                            echo "<td class='gray'><a href='?matricola=" . $row['id_technician'] . "'>" . $row['firstname'] . "</a></td>";
                            echo "<td><a href='?matricola=" . $row['id_technician'] . "'>" . $row['lastname'] . "</a></td>";
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
                        
                            switch($row['power']){
                                case 0:
                                    echo "<td>Dipendente</td>";
                                    break;
                                case 1:
                                    echo "<td>Supervisore</td>";
                                    break;
                                case 2:
                                    echo "<td>Capo Ufficio</td>";
                                    break;
                                default:
                                    echo "<td>Unknown</td>";
                            }
                                
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<input type='submit' value='cancella selezionati' name='submit'>";
                    echo "</form>";
                }           
                echo "</div>";
                }
                //dipendente normale, stampo il supervisore
                if($utente->getPower() > 0 ){ 
                    echo "<br><div class='superiori'>";
                    //vado a ricercare il superiore di questo
                    $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :id_supervisor;";
                    $values[':id_supervisor'] = $utente->getIdSupervisor();
                    //var_dump($utente);
                    //uso $utente->getMatricola perchè così sono sicuro che visualizzo l'utente loggato

                    global $connection;
                    $statement = $connection->prepare($query);
                    try{
                        $statement->execute($values);
                    }catch(PDOException $e){
                        echo "<p class='centered error'>Nessun superiore trovato</p>";
                        //echo $e;
                        //die();
                    }

                    //se trovo sottoposti stampo
                    if($statement->rowCount() > 0){
                        $arrayTech=$statement->fetchAll(PDO::FETCH_ASSOC);
                        echo "<form method='post' action=''>";
                        echo "<table class='multi'>";
                        echo "<thead><tr>";
                        echo "  <th> </th>
                            <th>Nome</th>
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
                                echo "<td><input type='checkbox' name='id_techs[]' value='" .  $row['id_technician'] . "'></td>";
                                echo "<td class='gray'><a href='?matricola=" . $row['id_technician'] . "'>" . $row['firstname'] . "</a></td>";
                                echo "<td><a href='?matricola=" . $row['id_technician'] . "'>" . $row['lastname'] . "</a></td>";
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
                            
                                switch($row['power']){
                                    case 0:
                                        echo "<td>Dipendente</td>";
                                        break;
                                    case 1:
                                        echo "<td>Supervisore</td>";
                                        break;
                                    case 2:
                                        echo "<td>Capo Ufficio</td>";
                                        break;
                                    default:
                                        echo "<td>Unknown</td>";
                                }
                                    
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "<input type='submit' value='cancella selezionati' name='submit'>";
                        echo "</form>";
                    }           
                    echo "</div>";
                }
        
    }else if(isset($_GET['idUser'])){

        //preparo la query per la ricerca e l'array per i valori
        $query = "SELECT * FROM user LEFT JOIN customer USING(id_user) WHERE id_user = :idUser;";
        $values[':idUser'] = $_GET['idUser'];

        global $connection;
        $statement = $connection->prepare($query);
        //se query multiple prepara prima e poi fai nel for con i rispetti values
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            echo "<p class='centered error'>Nessun utente trovato</p>";
            //die();
            echo $e;
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);  
        else
            echo "<p class='centered error'>Nessun utente trovato</p>";
        //var_dump($statement);


        echo "<table class='single'>";
        echo "  
        <tr><td>ID</td><td>" . $statement['id_user'] . "</td></tr>
        <tr><td>Username</td><td class='gray'>" . $statement['username'] . "</td></tr>
        <tr><td>Email</td><td>" . $statement['email'] . "</td></tr>
        <tr><td>Nome</td><td class='gray'>" . $statement['firstname'] . "</td></tr>
        <tr><td>Cognome</td><td>" . $statement['lastname'] . "</td></tr>
        <tr><td>Data di nascita</td><td class='gray'>" . $statement['birth_date'] . "</td></tr>
        <tr><td>Genere</td><td>" . $statement['gender'] . "</td></tr>
        <tr><td>Indirizzo</td><td class='gray'>" . $statement['address'] . "</td></tr>
        <tr><td>Citt&agrave;</td><td>" . $statement['city'] . "</td></tr>
        <tr><td>CAP</td><td class='gray'>" . $statement['postal_code'] . "</td></tr>";
        echo "</table>";        

        /*
            aggiungere query per visualizzare i lavori relativi alla persona
            i suoi ticket
            i suoi preventivi
            varie ed eventuali
        */
    }
    

}

    