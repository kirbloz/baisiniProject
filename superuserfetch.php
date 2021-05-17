<?php
    @include('php/header.php');
    if(!checkActiveSuper())
        header('location:superlogin.php?error=nosession'); //session

    //salvo il power level
    @include('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());


    //in base alla var specificata in get vado a eseguire script diversi
    //prima controllo se è necessario il redirect
    //se idUser o matricola sono != empty allora entro nelle condizioni
    if(! (isset($_GET)   &&  (  isset($_GET['select']) || (  isset($_GET['idUser']) || isset($_GET['matricola']) ))     )){
        header('location:areaSuperutente.php');
    }
    /*
        if(! (isset($_GET)   &&  (isset($_GET['select']) || ((isset($_GET['idUser']) || isset($_GET['matricola'])))     ));
        dopo aver controllato che posso essere in questa pagina, 
        !(c'è get AND c'è select OR (idUser OR matricola))
        decido se visualizzare tabelle multiple(tutti gli utenti/superutenti) 
        o tabelle singole(1 utente/superutente)
    */
    else {
        //se ho idUser o matricola allora devo stampare le tabelle singole
        if(isset($_GET['idUser']) || isset($_GET['matricola'])){

        //stampo il tasto per tornare indietro
        ?>
            <div class="wrapper user-area">
                <div class='color-lightb user-nav'>
                    <ul>
                        <li><?php
                        if(isset($_GET['matricola']))
                            echo "<a href='superuserfetch.php?select=techs'>Torna indietro</a>";
                        else if(isset($_GET['idUser']))
                            echo "<a href='superuserfetch.php?select=users'>Torna indietro</a>";
                        ?></li>
                    </ul>
                </div>
        <?php

        //includo la pagina showdetails che si occupa di gestire le tabelle singole
        if( isset($_GET['matricola']) && $utente->getPower() > 1)
            @require('php/showDetails.inc.php');
        else if( isset($_GET['idUser']) && $utente->getPower() > 0)
            @require('php/showDetails.inc.php');
        else
            echo "<br><br><p class='centered error' style='margin: 10px 0px;'> Non hai i privilegi per accedere a quest'area. </p>";  


        }else{
            //mi preparo a visualizzare le tabelle multiple
            //header se entro in select, quindi se faccio tabelle multiple
            echo '<div class="wrapper user-area">
                        <div class="color-lightb user-nav">
                        <ul>
                            <li><a href="areaSuperutente.php">Torna indietro</a></li>
                        </ul>
                    </div>
                    <br><br>';

            //se effettivamente ho specificato dei parametri di ricerca aka il select vado
            //a eseguire lo script necessario
            if($_GET['select'] == 'users'){
                /*
                                    TABELLA UTENTI
                */
                if($utente->getPower()<1){
                    echo "<p class='centered error' style='margin: 10px 0px;'> Non hai i privilegi per accedere a quest'area. </p>";   
                }else{
                    //controlla se c'è il submit
                    //controlla il post
                    //elimina gli utenti
                    if(isset($_POST['submit'])){
                        //var_dump($_POST);
                        echo "<br>tot selected: " . sizeof($_POST['id_users']) . "<br>";
                        $deleted = sizeof($_POST['id_users']) ;
            
                        //preparo la connessione e la query
                        $query = "DELETE FROM user WHERE id_user = :id_user";
                        global $connection;
                        $statement = $connection->prepare($query);
            
                        //eseguola query per ogni id
                        foreach($_POST['id_users'] as $userid){
                            $values[':id_user'] = $userid;
                            try{
                                $statement->execute($values);
                            }catch(PDOException $e){
                                echo $e;
                                $deleted--;
                            }
                        }
                        echo "<br>tot deleted: " . sizeof($_POST['id_users']) . "<br>";
                        unset($_POST);
                    }
                        
            
                    echo "</div><div class='wrapper'>";

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
                    echo "<form method='post' action=''>";
                    echo "<table class='multi'>";
                    echo "<thead><tr>";
                    //valutare di inserire dei tasti per eliminare certi utenti
                    echo "  <th> </th>
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
                            echo "<td><input type='checkbox' name='id_users[]' value='" .  $row['id_user'] . "'></td>";
                            echo "<td class='gray'><a href='?idUser=" . $row['id_user'] . "'>" . $row['username'] . "</a></td>";
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
                    echo "<input type='submit' class='btn' value='Cancella selezionati' name='submit'>";
                    echo "</form>";
                }
                
                //echo "fect users";

            }else if($_GET['select'] == 'techs'){
                /*
                                        TABELLA TECNICI
                */
                if($utente->getPower()<2){
                    echo "<p class='centered error'> Non hai i privilegi per accedere a quest'area. </p>";   
                }else{
                    //controlla se c'è il submit
                    //controlla il post
                    //elimina gli utenti
                    if(isset($_POST['submit'])){
                        //var_dump($_POST);
                        echo "<br>tot selected: " . sizeof($_POST['id_techs']) . "<br>";
                        $deleted = sizeof($_POST['id_techs']) ;
            
                        //preparo la connessione e la query
                        $query = "DELETE FROM technician WHERE id_technician = :id_tech";
                        global $connection;
                        $statement = $connection->prepare($query);
            
                        //eseguola query per ogni id
                        foreach($_POST['id_techs'] as $techid){
                            $values[':id_tech'] = $techid;
                            try{
                                $statement->execute($values);
                            }catch(PDOException $e){
                                echo "<p class='centered error'>" . $e . "</p>";
                                $deleted--;
                            }
                        }
                            echo "<br>tot deleted: " . sizeof($_POST['id_techs']) . "<br>";
                            unset($_POST);
                        }
            
            
                    echo "</div><div class='wrapper'>";
                    /**/
                    @include_once('../db/databasehandler.inc.php');
                
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
                    echo "<input type='submit' class='btn' value='Cancella selezionati' name='submit'>";
                    echo "</form>";
                }
                
                //echo "fect techs";
                
            }else if($_GET['select'] == 'components'){
                if($utente->getPower()<2){
                    echo "<p class='centered error'> Non hai i privilegi per accedere a quest'area. </p>";   
                }else{
            
                    echo "</div><div class='wrapper'>";
                    //@require_once('db/databasehandler.inc.php');
                
                    //cerco direttamente appoggiandomi all'entità superuser perchè ha un rapporto 1-1 con technician
                    $query = "SELECT component.name as name, price_ToSell, price_ToBuy, description, manifacturer.businness_name as businness_name, component.quantity_available as quantity
                        FROM component 
                        INNER JOIN category USING(id_category)
                        INNER JOIN manifacturer USING(id_manifacturer)
                        ORDER BY id_component ASC;";
                
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
                    echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " tipologie di componenti.<br><br>";
                    $arrayComp = ($statement->fetchAll(PDO::FETCH_ASSOC));
                    //var_dump($arrayComp);
                    if ($arrayComp == false)
                        echo "<p class='centered error'>Errore nell'esecuzione della query</p>";
                    else{
                        $tot = 0;
                        //inizio la stampa della tabella
                        echo "<table class='multi'>";
                        echo "<thead><tr>";
                        echo "<th>Nome</th>
                                <th>Prezzo d'Acquisto</th>
                                <th>Prezzo di Vendita</th>
                                <th>Categoria</th>
                                <th>Fornitore</th>
                                <th>Quantit&agrave;</th>";
                        echo "</tr></thead>";
                
                        foreach ($arrayComp as $row) {
                            $tot+=$row['quantity'];
                            echo "<tr>";
                                echo "<td class='gray'>" . $row['name'] . "</td>";
                                echo "<td>" . $row['price_ToBuy'] . "</td>";
                                echo "<td class='gray'>" . $row['price_ToSell'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td class='gray'>" . $row['businness_name'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                
                                }
                                    
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "<br><br>Nel database sono presenti " . $tot . " prodotti.<br><br>";
                    }
                    
            
            }else
                echo "<p class='centered error'>Parametri errati</p>";
        }
    }
?>	
