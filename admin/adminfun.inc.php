<?php

function fetchUsers()
{
    //controlla se c'è il submit
    //controlla il post
    //elimina gli utenti
    if (isset($_POST['submit'])) {
        //var_dump($_POST);
        echo "<br>tot selected: " . sizeof($_POST['id_users']) . "<br>";
        $deleted = sizeof($_POST['id_users']);

        //preparo la connessione e la query
        $query = "DELETE FROM user WHERE id_user = :id_user";
        global $connection;
        $statement = $connection->prepare($query);

        //eseguola query per ogni id
        foreach ($_POST['id_users'] as $userid) {
            $values[':id_user'] = $userid;
            try {
                $statement->execute($values);
            } catch (PDOException $e) {
                echo $e;
                $deleted--;
            }
        }
        echo "<br>tot deleted: " . sizeof($_POST['id_users']) . "<br>";
        unset($_POST);
    }


    echo "</div><br><div class='wrapper'>";

    @require_once('db/databasehandler.inc.php');
    global $connection;
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

function fetchTechs()
{
    //controlla se c'è il submit
    //controlla il post
    //elimina gli utenti
    if (isset($_POST['submit'])) {
        //var_dump($_POST);
        echo "<br>tot selected: " . sizeof($_POST['id_techs']) . "<br>";
        $deleted = sizeof($_POST['id_techs']);

        //preparo la connessione e la query
        $query = "DELETE FROM technician WHERE id_technician = :id_tech";
        global $connection;
        $statement = $connection->prepare($query);

        //eseguola query per ogni id
        foreach ($_POST['id_techs'] as $techid) {
            $values[':id_tech'] = $techid;
            try {
                $statement->execute($values);
            } catch (PDOException $e) {
                echo "<p class='centered error'>" . $e . "</p>";
                $deleted--;
            }
        }
        echo "<br>tot deleted: " . sizeof($_POST['id_techs']) . "<br>";
        unset($_POST);
    }


    echo "</div><br><div class='wrapper'>";
    /**/
    @require_once('db/databasehandler.inc.php');
    global $connection;
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
        if (!is_array($capo))
            echo "<td class='gray'> Unknown </td>";
        else if ($capo['firstname'] == $row['firstname'] && $capo['lastname'] == $row['lastname'])
            echo "<td class='gray'>Nessuno</td>";
        else
            echo "<td class='gray'>" . $capo['firstname'] . " " . $capo['lastname'] . "</td>";

        switch ($row['power']) {
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

function fetchComponents()
{
    echo "</div><br><div class='wrapper'>";

    @require_once('db/databasehandler.inc.php');
    global $connection;
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
    else {
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
            $tot += $row['quantity'];
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

function fetchMatricola(Superuser $utente)
{

    echo "</div><br><div class='wrapper'>";
    @require_once('db/databasehandler.inc.php');
    $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :matricola;";

    if (($_GET['matricola'] == 'self'))
        $values[':matricola'] = $utente->getMatricola();
    else
        $values[':matricola'] = $_GET['matricola'];
    //uso $utente->getMatricola perchè così sono sicuro che visualizzo l'utente loggato

    global $connection;
    $statement = $connection->prepare($query);

    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<p class='centered error'>Nessun dipendente trovato</p>";
        echo $e;
        //die();
    }


    if ($statement->rowCount() > 0)
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
    else
        echo "<p class='centered error'>Nessun dipendente trovato</p>";
    //var_dump($statement);

    /*
            TABELLA INDIVIDUALE DI UN TECHNICIAN
    */
    echo "<table class='single'>";
    echo "  
        <tr><td>ID</td><td>" . $statement['id_technician'] . "</td></tr>
        <tr><td>Nome</td><td class='gray'>" . $statement['firstname'] . "</td></tr>
        <tr><td>Cognome</td><td>" . $statement['lastname'] . "</td></tr>
        <tr><td>Email</td><td class='gray'>" . $statement['email'] . "</td></tr>
        <tr><td>Data di nascita</td><td>" . $statement['birth_date'] . "</td></tr>
        <tr><td>Genere</td><td class='gray'>" . $statement['gender'] . "</td></tr>";

    //controllo che id_supervisor non sia null (in quel caso non ho supervisori) e poi stampo il nome
    if (empty($statement['id_supervisor']))
        echo "<tr><td>Supervisore</td><td>Nessuno</td></tr>";
    else {
        $capo = superuserExists($statement['id_supervisor']);
        if (!is_array($capo))
            echo "<tr><td>Supervisore</td><td> Unknown </td></tr>";
        else echo "<tr><td>Supervisore</td><td>" . $capo['firstname'] . " " . $capo['lastname'] . "</td></tr>";
        $capo = NULL;
    }

    //switch per indicare il ruolo del tecnico all'interno dell'azienda
    switch ($statement['power']) {
        case 0:
            $string = "Dipendente";
            break;
        case 1:
            $string = "Supervisore";
            break;
        case 2:
            $string = "Capo Ufficio";
            break;
        default:
            $string = "Unknown";
    }

    echo "<tr><td>Power Level</td><td class='gray'>" . $string . "</td></tr>
            <tr><td>Ufficio</td><td>" . $statement['id_office'] . "</td></tr>";
    echo "</table>";

    /*
        STAMPO TABELLE SOTTOPOSTI SE SONO UN POWER > 1 ALTRIMENTI IL SUPERIORE
    */

    //capoufficio e supervisore, stampo i dipendenti
    if ($utente->getPower() > 0) {
        echo "<br><div class='sottoposti'>";

        //vado a ricercare tutti i tecnici sottoposti a questo
        $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE technician.id_supervisor = :matricola;";
        $values[':matricola'] = $_GET['matricola'];
        //nonuso $utente->getMatricola perchè visualizzo l'utente loggato, uso invece il GET

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
            echo "<p>Elenco tabulare dei sottoposti: </p>";
        } catch (PDOException $e) {
            echo "<p class='centered error'>Errore. Nessun sottoposto trovato</p>";
            //echo $e;
            die();
        }

        //se trovo sottoposti stampo
        if ($statement->rowCount() > 0) {
            $arrayTech = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                if (!is_array($capo))
                    echo "<td class='gray'> Unknown </td>";
                else if ($capo['firstname'] == $row['firstname'] && $capo['lastname'] == $row['lastname'])
                    echo "<td class='gray'>Nessuno</td>";
                else
                    echo "<td class='gray'>" . $capo['firstname'] . " " . $capo['lastname'] . "</td>";

                switch ($row['power']) {
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
            echo "<br><input type='submit' value='cancella selezionati' name='submit'>";
            echo "</form>";
        } else
            echo "<p class='error'> Nessun sottoposto trovato</p>";
        echo "</div>";
    }
    //dipendente normale, stampo il supervisore
    if ($utente->getPower() == 0) {
        echo "<br><div class='superiori'>";
        //vado a ricercare il superiore di questo
        $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :id_supervisor;";
        $values[':id_supervisor'] = $utente->getIdSupervisor();
        //var_dump($utente);
        //uso $utente->getIdSupervisor perchè così sono sicuro che visualizzo l'utente loggato

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            echo "<p class='centered error'>Nessun superiore trovato</p>";
            //echo $e;
            //die();
        }

        //se trovo sottoposti stampo
        if ($statement->rowCount() > 0) {
            $arrayTech = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                if (!is_array($capo))
                    echo "<td class='gray'> Unknown </td>";
                else if ($capo['firstname'] == $row['firstname'] && $capo['lastname'] == $row['lastname'])
                    echo "<td class='gray'>Nessuno</td>";
                else
                    echo "<td class='gray'>" . $capo['firstname'] . " " . $capo['lastname'] . "</td>";

                switch ($row['power']) {
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
}

function fetchidUser()
{


    //preparo la query per la ricerca e l'array per i valori
    echo "</div><br><br><div class='wrapper'><h4>Informazioni cliente</h4><hr>";
    @require_once('db/databasehandler.inc.php');
    $query = "SELECT * FROM user LEFT JOIN customer USING(id_user) WHERE id_user = :idUser;";
    $values[':idUser'] = $_GET['idUser'];

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<p class='centered error'>Nessun utente trovato</p>";
        //die();
        echo $e;
    }


    if ($statement->rowCount() > 0)
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
    else
        echo "<p class='centered error'>Nessun utente trovato</p>";
    //var_dump($statement);

    if ($statement['gender'] == "M")
        $temp = "Uomo";
    else if ($statement['gender'] == "F")
        $temp = "Donna";
    else
        $temp = "Non specificato";

    echo '<div class="container ">
            <div class="row single">
                
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                IdUser:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" value="' .htmlentities($statement['id_user']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Nome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="firstname" value="' .htmlentities($statement['firstname']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Cognome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="lastname" value="' .htmlentities($statement['lastname']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Username:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="username" value="' .htmlentities($statement['username']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Email:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="email" value="' .htmlentities($statement['email']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Data di nascita:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="birth_date" value="' .htmlentities($statement['birth_date']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Genere:
                            </div>
                            <div class="col-sm-4" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="gender" value="' .htmlentities($temp) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Citt&agrave;:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="city" value="' .htmlentities($statement['city']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Indirizzo:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="address" value="' .htmlentities($statement['address']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                CAP:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="postal_code" value="' .htmlentities($statement['postal_code']) .'" disabled> 
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>';

    /*
            aggiungere query per visualizzare i lavori relativi alla persona
            i suoi ticket
            i suoi preventivi
            varie ed eventuali
        */
}