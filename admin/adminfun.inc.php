<?php

function fetchUsers()
{
    //controlla se c'è il submit
    //controlla il post
    //elimina gli utenti
    if (isset($_POST['submit'])) {
        //var_dump($_POST);
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
        echo "</div><br><p class='alert alert-success col-md-5 centered'> Hai eliminato " . sizeof($_POST['id_users']) . " utenti.</p><div>";
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
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";
    }

    if ($statement->rowCount() < 0) {
        echo "<p  class='centered alert alert-danger'>Nessun dipendente trovato</p>";
    }
    echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " utenti.<br><br>";
    $arrayTech = ($statement->fetchAll(PDO::FETCH_ASSOC));
    //var_dump($arrayTech);
    if ($arrayTech == false)
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";

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
    echo '<div class="row" style="margin: 10px 40px;">
            <div class="col-md-6">
            <input type="submit" class="btn btn-secondary" value="Elimina selezionati" name="submit">
                <span></span>
                <input type="reset" class="btn btn-default" value="Reset">
                </form>
            </div>
        </div>';
}

function fetchTechs()
{
    //controlla se c'è il submit
    //controlla il post
    //elimina gli utenti
    if (isset($_POST['submit'])) {
        //var_dump($_POST);
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
                echo "<p  class='centered alert alert-danger'>" . $e . "</p>";
                $deleted--;
            }
        }
        echo "</div><br><p class='alert alert-success col-md-5 centered'> Hai eliminato " . sizeof($_POST['id_techs']) . " dipendenti.</p><div>";
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
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";
    }

    if ($statement->rowCount() < 0) {
        echo "<p  class='centered alert alert-danger'>Nessun dipendente trovato</p>";
    }
    echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " dipendenti.<br><br>";
    $arrayTech = ($statement->fetchAll(PDO::FETCH_ASSOC));
    //var_dump($arrayTech);
    if ($arrayTech == false)
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";

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
            echo "<td class='gray'> Nessuno </td>";
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
    echo '<div class="row" style="margin: 10px 40px;">
            <div class="col-md-6">
            <input type="submit" class="btn btn-secondary" value="Elimina selezionati" name="submit">
                <span></span>
                <input type="reset" class="btn btn-default" value="Reset">
                </form>
            </div>
        </div>';
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
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";
    }

    if ($statement->rowCount() < 0) {
        echo "<p  class='centered alert alert-danger'>Nessun dipendente trovato</p>";
    }
    echo "<br><br>Nel database sono presenti " . $statement->rowCount() . " tipologie di componenti.<br><br>";
    $arrayComp = ($statement->fetchAll(PDO::FETCH_ASSOC));
    //var_dump($arrayComp);
    if ($arrayComp == false)
        echo "<p  class='centered alert alert-danger'>Errore nell'esecuzione della query</p>";
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
    @require_once('db/databasehandler.inc.php');
    if (isset($_POST['submit'])) {
        //var_dump($_POST);
        $deleted = sizeof($_POST['id_users']);

        //preparo la connessione e la query
        $query = "DELETE FROM technician WHERE id_technician = :id_technician";
        global $connection;
        $statement = $connection->prepare($query);

        //eseguola query per ogni id
        foreach ($_POST['id_techs'] as $userid) {
            $values[':id_techs'] = $userid;
            try {
                $statement->execute($values);
            } catch (PDOException $e) {
                echo "<p  class='centered alert alert-danger'>" . $e . "</p>";
                $deleted--;
            }
        }
        echo "</div><br><p class='alert alert-success col-md-5 centered'> Hai eliminato " . sizeof($_POST['id_techs']) . " dipendenti.</p><div>";
        unset($_POST);
    }

    echo "</div><br><div class='wrapper'>";

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
        echo "<p class='centered alert alert-danger'>Nessun dipendente trovato</p>";
        echo $e;
        //die();
    }


    if ($statement->rowCount() > 0)
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
    else
        echo "<p class='centered alert alert-danger'> Nessun dipendente trovato</p>";
    //var_dump($statement);

    /*
            TABELLA INDIVIDUALE DI UN TECHNICIAN
    */

    if ($statement['gender'] == "M")
        $temp = "Uomo";
    else if ($statement['gender'] == "F")
        $temp = "Donna";
    else
        $temp = "Non specificato";

    echo '<div class="row single">
                <form class="form-horizontal " method="" action="">
                    <div class="form-group mx-auto">
                        <div class="row">
                            <div class="col-sm-2">
                                Matricola:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($statement['id_technician']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Nome:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($statement['firstname']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Cognome:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($statement['lastname']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Email:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($statement['email']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Data di nascita:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="date" class="form-control" name="" value="' . htmlentities($statement['birth_date']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Genere:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <select class="form-control custom-select" name="">
                                    <option selected disabled>' . htmlentities($temp) . '</option>
                                </select>
                            </div>
                        </div>';

    //controllo che id_supervisor non sia null (in quel caso non ho supervisori) e poi stampo il nome
    if (empty($statement['id_supervisor']))
        echo '<div class="row">
                            <div class="col-sm-2">
                                Supervisore:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="Nessuno" disabled> 
                            </div>
                        </div>';
    else {
        $capo = superuserExists($statement['id_supervisor']);
        if (!is_array($capo))
            echo '<div class="row">
                            <div class="col-sm-2">
                                Supervisore:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="Nessuno" disabled> 
                            </div>
                        </div>';
        else
            echo '<div class="row">
                    <div class="col-sm-2">
                        Supervisore:
                    </div>
                    <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                        <input type="text" class="form-control" name="" placeholder="' . $capo['lastname'] . " " . $capo['lastname'] . '" disabled> 
                    </div>
                </div>';
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

    echo    '<div class="row">
                            <div class="col-sm-2">
                                Power Level:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($string) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Ufficio:
                            </div>
                            <div class="col-sm-7 col-md-5" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' . htmlentities($statement['id_office']) . '" disabled> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>';

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
            echo "<p class='centered'>Elenco tabulare dei sottoposti: </p>";
        } catch (PDOException $e) {
            echo "<p class='centered alert alert-danger'>Errore. Nessun sottoposto trovato</p>";
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
            echo '<div class="row" style="margin: 10px 40px;">
                <div class="col-md-6">
                <input type="submit" class="btn btn-secondary" value="Elimina selezionati" name="submit">
                    <span></span>
                    <input type="reset" class="btn btn-default" value="Reset">
                    </form>
                </div>
            </div>';
        } else
            echo "<br><p class='centered alert alert-danger'>Nessun sottoposto trovato</p>";
        echo "</div><br>";
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
            echo '<div class="row" style="margin: 10px 40px;">
                    <div class="col-md-6">
                    <input type="submit" class="btn btn-secondary" value="Elimina selezionati" name="submit">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Reset">
                        </form>
                    </div>
                </div>';
        }
        echo "</div><br>";
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
                                <input type="text" class="form-control" name="" value="' . htmlentities($statement['id_user']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Nome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="firstname" value="' . htmlentities($statement['firstname']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Cognome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="lastname" value="' . htmlentities($statement['lastname']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Username:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="username" value="' . htmlentities($statement['username']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Email:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="email" value="' . htmlentities($statement['email']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Data di nascita:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="birth_date" value="' . htmlentities($statement['birth_date']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Genere:
                            </div>
                            <div class="col-sm-4" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="gender" value="' . htmlentities($temp) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Citt&agrave;:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="city" value="' . htmlentities($statement['city']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Indirizzo:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="address" value="' . htmlentities($statement['address']) . '" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                CAP:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="postal_code" value="' . htmlentities($statement['postal_code']) . '" disabled> 
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>';
}

function fetchWorks()
{
    $query = "SELECT DISTINCT id_user, customer.firstname, customer.lastname 
            FROM work RIGHT JOIN customer USING (id_customer)
            ORDER BY customer.lastname ASC;";

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute();
    } catch (PDOException $e) {
        echo "<br><p class='centered alert alert-info col-6'>Errore. Riprova pi&ugrave; tardi.</p>";
        echo $e;
        //die();
    }

    if ($statement->rowCount() < 0) {
        echo "<p class='centered alert alert-info col-6'>Nessun cliente trovato nel database.</p>";
    } else {

        $arrayUsers = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayUsers);
?>
        <div class="wrapper user-info" style="text-align:left;">
            <div class="row">
                <?php
                echo 'Nel database sono presenti ' . $statement->rowCount() . ' clienti.<br><br>';
                ?>
            </div>
            <form class="row" method="get" action="">
                <div class="row form-group">
                    <div class="col-sm-5">
                        <select class="form-select" name="IdUserWork">
                            <option selected disabled>Scegli il cliente..</option>
                            <?php
                            foreach ($arrayUsers as $user) {
                                echo "<option value=\"" . $user['id_user'] . "\">" . $user['lastname'] . " " . $user['firstname'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary" name="submit" value="Trova">
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary" name="submit" value="Aggiungi">
                    </div>
                    <input type="hidden" name="select" value="works">
                </div>
            </form>
            <hr>
        </div>
    <?php
    }
}


function fetchWorksShow(int $idUser)
{
    date_default_timezone_set('Europe/Rome');
    $query = "SELECT work.* FROM work INNER JOIN customer USING (id_customer) WHERE id_user = :id_user;";
    $values = array(
        ':id_user' => $idUser
    );

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<p class='centered alert alert-info col-6'>Nessun intervento programmato trovato.</p>";
        echo $e;
        die();
    }

    if ($statement->rowCount() > 0) {
        $arrayWork = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayWork);
        //die();
        if ($arrayWork == false)
            echo "<p class='centered alert alert-info col-6'>Errore nell'esecuzione della query</p>";
        else {
            $tot = 0;
            //inizio la stampa della serie
            echo '<div class="wrapper">';
            foreach ($arrayWork as $row) {
                if (isset($row['start_date'])) {
                    $dataI = date('d-m-Y', strtotime($row['start_date']));
                } else
                    $dataI = NULL;
                if (isset($row['finish_date'])) {
                    $dataF = date('d-m-Y', strtotime($row['start_date']));
                } else
                    $dataF = NULL;

                echo "<div class='container ticket' >";
                echo "<div class='row '>";
                echo "<div class='col-sm-4 '><b>ID Intervento:</b> " . $row['id_work'] . "</div>";
                echo "<div class='col-sm-4 '>Data Inizio: " . $dataI . "</div>";
                echo "<div class='col-sm-4 '>Data Fine: " . $dataF . "</div>";
                echo "</div>";
                echo "<div class='row'>";
                echo "<div class='col-sm-4 '>Citt&agrave;: " . $row['city'] . "</div>";
                echo "<div class='col-sm-4 '>Indirizzo: " . $row['address'] . "</div>";
                echo "<div class='col-sm-4 '>CAP: " . $row['postal_code'] . "</div>";
                echo "</div>";
                echo "<div class='row'>";
                echo "<div class='col m-1'><b>Descrizione:</b> " . $row['description'] . "</div>";
                echo "</div>";

                /*stampo i tecnici impegnati nel lavoro*/
                echo "<div class='row'>";
                $query = "SELECT firstname, lastname FROM technician INNER JOIN carry_out USING (id_technician) WHERE id_work = :id_work";
                $values = array(
                    ':id_work' => $row['id_work']
                );

                $statement = $connection->prepare($query);
                //se query multiple prepara prima e poi fai nel for con i rispetti values
                try {
                    $statement->execute($values);
                } catch (PDOException $e) {
                    echo "<p>Nessun tecnico assegnato all'intervento.</p>";
                    //echo $e;
                    //die();
                }

                if ($statement->rowCount() > 0 && !isset($e)) {
                    echo "<div class='col m-1'><b>Tecnici assegnato all'intervento:</b></div><br>";
                    echo "<ul>";
                    $arrayWorkers = ($statement->fetchAll(PDO::FETCH_ASSOC));
                    foreach ($arrayWorkers as $innerrow) {
                        echo "<li>" . $innerrow['lastname'] . " " . $innerrow['firstname'] . "</li>";
                    }
                    echo "</ul>";
                }

                echo "</div>";
                echo "</div><br><br>";
            }
        }
    } else if (!$statement) //errore
        echo "<p class='centered alert alert-info col-6'>Errore nell'esecuzione della query, riprova più tardi.</p>";
    else
        echo "<p class='centered alert alert-info col-6'>Nessun intervento trovato</p><br><br><br>";
}

function fetchWorksAdd(int $idUser)
{
    $query = "SELECT * FROM user INNER JOIN customer USING (id_user) WHERE id_user = :id_user;";
    $values[':id_user'] = $idUser;

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo $e;
        echo "<p class='centered alert alert-info col-6'>Qualcosa &egrave; andato storto. Riprova pi&ugrave; tardi.</p>";
        die();
    }

    if ($statement->rowCount() > 0)
        $arrayUser = $statement->fetch(PDO::FETCH_ASSOC);
    else {
        echo "<p class='centered alert alert-info col-6'>Cliente non trovato.</p>";
        die();
    }

    //la seconda query mi prepara l'array di tecnici disponibili
    $query = "SELECT id_technician, firstname, lastname 
                FROM technician;";
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute();
    } catch (PDOException $e) {
        echo $e;
        echo "<p class='centered alert alert-info col-6'>Qualcosa &egrave; andato storto. Riprova pi&ugrave; tardi.</p>";
        die();
    }

    if ($statement->rowCount() > 0)
        $arrayTechs = $statement->fetchAll(PDO::FETCH_ASSOC);
    else {
        echo "<p class='centered alert alert-info col-6'>Nessun dipendente trovato.</p>";
        die();
    }


    //echo "stampa form parzialmente completato con i dati dell'idUserWork";
    echo "<h4 class='centered'>Compila i campi</h4>";
    echo '
    <div class="container">
        <div class="row single">
            <form class="form-horizontal" method="post" action="admin/workarea.inc.php">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            IdUser:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['id_user'] . '" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Nome:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['firstname'] . '" value="" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Cognome:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['lastname'] . '" value="" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Data di nascita:
                        </div>
                        <div class="col-sm-4" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['birth_date'] . '" value="" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Genere:
                        </div>
                        <div class="col-sm-3" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control custom-select" name="" placeholder="' . $arrayUser['gender'] . '" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Citt&agrave;:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['city'] . '" value="" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Indirizzo:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['address'] . '" value="" disabled> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            CAP:
                        </div>
                        <div class="col-sm-6" style="text-align:left; margin:5px;">
                            <input type="text" class="form-control" name="" placeholder="' . $arrayUser['postal_code'] . '"value="" disabled> 
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            Inizio:
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="start_date"  required> 
                        </div>
                        <div class="col-sm-2">
                            Fine:
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="finish_date"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="request">Descrizione:</label>
                            <textarea name="description" class="form-control rounded-25" id="request" rows="5" max-rows="8"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Tecnici coinvolti:
                        </div>
                        <div class="col-md-3">
                            <select class="form-control custom-select" name="tech1">
                                <option selected value=""></option>';

    foreach ($arrayTechs as $tech) {
        echo "<option value=\"" . $tech['id_technician'] . "\">" . $tech['lastname'] . " " . $tech['firstname'] . "</option>";
    }

    echo '</select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control custom-select" name="tech2">
                                <option selected value=""></option>';

    foreach ($arrayTechs as $tech) {
        echo "<option value=\"" . $tech['id_technician'] . "\">" . $tech['lastname'] . " " . $tech['firstname'] . "</option>";
    }

    echo '</select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control custom-select" name="tech3">
                                <option selected value=""></option>';

    foreach ($arrayTechs as $tech) {
        echo "<option value=\"" . $tech['id_technician'] . "\">" . $tech['lastname'] . " " . $tech['firstname'] . "</option>";
    }

    echo '</select>
                        </div>
                    </div>
                    <input type="hidden" name="id_customer" value="' . $arrayUser['id_customer'] . '">
                    <input type="hidden" name="address" value="' . $arrayUser['address'] . '"> 
                    <input type="hidden" name="postal_code" value="' . $arrayUser['postal_code'] . '"> 
                    <input type="hidden" name="city" value="' . $arrayUser['city'] . '">  
                        
                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" name="submit" value="Aggiungi">
                            <span></span>
                            <input type="reset" class="btn btn-default" value="Reset">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function saveWorkDB($array)
{
    require('../db/databasehandler.inc.php');

    $connection->beginTransaction();
    $query = "INSERT INTO work(description, start_date, postal_code, city, address, finish_date, id_customer) VALUES(:description, :start_date, :postal_code, :city, :address, :finish_date, :id_customer)";

    //global $connection;
    if ($array['postal_code'] == "")
        $array['postal_code'] = NULL;
    if ($array['address'] == "")
        $array['address'] = NULL;
    if ($array['finish_date'] == "")
        $array['finish_date'] = NULL;

    $values = array(
        ':description' => $array['description'],
        ':start_date' => $array['start_date'],
        ':postal_code' => $array['postal_code'],
        ':city' => $array['city'],
        ':address' => $array['address'],
        ':finish_date' => $array['finish_date'],
        ':id_customer' => $array['id_customer']
    );

    $statement = $connection->prepare($query);
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        //return false;
        //var_dump($statement);
        $connection->rollBack();
        echo "<br>";
        echo $e;
        header('location:../superuserfetch.php?select=works&error=query');
    }

    //devo popolare anche carryout quindi vado a vedere quanti tecnici ho e eseguo in un foreach
    //per sapere quale id_work prendo quello più recente

    $query = "SELECT MAX(id_work) as id_work FROM work WHERE id_customer = :id_customer;";
    $statement = $connection->prepare($query);
    $values = array();
    $values[':id_customer'] = $array['id_customer'];
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<br>";
        header('location:../superuserfetch.php?select=works&error=query');
    }

    echo "<br><br>";
    $id_work = $statement->fetch(PDO::FETCH_ASSOC)['id_work'];
    $values = array();

    $query = "INSERT INTO carry_out(id_work, id_technician, total_duration) VALUES(:id_work, :id_technician, :total_duration)";
    $statement = $connection->prepare($query);

    for ($i = 1; $i <= 3; $i++) {
        //se nel select non è stato impostato nessun tecnico, allora il valore nel post sarà "", quindi scarto
        if ($array['tech' . $i] != "") {
            //array è il POST
            $values = array(
                ':id_work' => $id_work,
                ':id_technician' => $array['tech' . $i],
                ':total_duration' => 0
            );
            try {
                $statement->execute($values);
                //echo "<br> QUERY NUMERO " . $i;
            } catch (PDOException $e) {
                $connection->rollBack();
                header('location:../superuserfetch.php?select=works&error=query');
            }
        }
    }

    //committo le query accumulate fin'ora
    $connection->commit();
}

function fetchTickets()
{
    $query = "SELECT DISTINCT id_user, username
            FROM ticket RIGHT JOIN user USING (id_user)
            ORDER BY username ASC;";

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute();
    } catch (PDOException $e) {
        echo "<br><p class='centered alert alert-info col-6'>Errore. Riprova pi&ugrave; tardi.</p>";
        echo $e;
        //die();
    }

    if ($statement->rowCount() < 0) {
        echo "<p class='centered alert alert-info col-6'>Nessun utente trovato nel database.</p>";
    } else {

        $arrayUsers = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayUsers);
    ?>
        <div class="wrapper user-info" style="text-align:left;">
            <div class="row">
                <?php
                echo 'Nel database sono presenti ' . $statement->rowCount() . ' utenti.<br><br>';
                ?>
            </div>
            <form class="row" method="get" action="">
                <div class="row form-group">
                    <div class="col-sm-5">
                        <select class="form-select" name="idUserTicket">
                            <!-- la form richiama superuserfetch-->
                            <option selected disabled>Scegli il cliente..</option>

                            <?php
                            foreach ($arrayUsers as $user) {
                                echo "<option value=\"" . $user['id_user'] . "\">" . $user['username'] . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary" name="submit" value="Trova">
                    </div>
                    <input type="hidden" name="select" value="tickets">
                </div>
            </form>
            <hr>
        </div>
<?php
    }
}

function fetchTicketsShow($idUser)
{
    date_default_timezone_set('Europe/Rome');
    $query = "SELECT ticket.* FROM ticket INNER JOIN user USING (id_user) WHERE id_user = :id_user;";
    $values = array(
        ':id_user' => $idUser
    );

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<p class='centered alert alert-info col-6'>Nessun ticket trovato.</p>";
        echo $e;
        die();
    }

    if ($statement->rowCount() > 0) {

        echo "Nel database sono presenti " . $statement->rowCount() . " tickets.<br><br>";
        $arrayTicket = ($statement->fetchAll(PDO::FETCH_ASSOC));
        //var_dump($arrayTicket);
        //die();
        if ($arrayTicket == false)
            echo "<p class='centered alert alert-info col-6'>Errore nell'esecuzione della query</p>";
        else {
            $tot = 0;
            //inizio la stampa della serie
            foreach ($arrayTicket as $row) {
                $orario = strtotime($row['date']);
                if ($row['isOpen'])
                    $status = 'Aperto';
                else
                    $status = 'Chiuso';

                echo "<div class='container ticket' >";
                echo "<form action='admin/ticketarea.inc.php' method='post'><div class='row'>";
                echo "<div class='col-sm-4 m-1'><b>ID Ticket:</b> " . $row['id_ticket'] . "</div>";
                echo "<div class='col-sm-4 m-1'>Titolo: " . $row['title_request'] . "</div>";
                echo "<div class='col-sm-4 m-1'>Data: " . date('d-m-Y', $orario) . "</div>";
                echo "<div class='col-sm-4 m-1'>Status: " . $status . "</div>";
                echo "</div>";
                echo "<div class='row'>";
                echo "<div class='col m-1'><b>Contenuto:</b> " . $row['description'] . "</div>";
                echo "</div>";
                echo '<div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" name="submit" value="Modifica Status">
                            <span></span>
                            <input type="submit" class="btn btn-danger" name="submit" value="Elimina">

                            <input type="hidden" name="id_ticket" value="' . $row['id_ticket']  . '">
                            <input type="hidden" name="isOpen" value="' . $row['isOpen']  . '">
                            <input type="hidden" name="id_user" value="'. $idUser .'">
                            </form>
                        </div>
                    </div>';
                echo "</div><br><br>";
            }
        }
    } else if (!$statement) //errore
        echo "<p class='centered alert alert-info col-6'>Errore nell'esecuzione della query, riprova più tardi.</p>";
    else
        echo "<p class='centered alert alert-info col-6'>Nessun intervento trovato</p><br><br><br>";
}

function deleteTicketDB($id_ticket)
{
    $query = "DELETE FROM ticket WHERE id_ticket = :id_ticket;";
    $values = array(
        ':id_ticket' => $id_ticket
    );

    global $connection;
    $statement = $connection->prepare($query);

    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        /*echo "<p class='centered alert alert-info col-6'>Ticket inesistente.</p>";
        echo $e;
        die();*/
        return false;
    }
    return true;
}

function editTicketDB($id_ticket, $isOpen, $idUser)
{
    $query = "UPDATE ticket SET isOpen = :bin WHERE id_ticket = :id_ticket;";

    if ($isOpen)
        $isOpen = 0;
    else
        $isOpen = 1;

    $values = array(
        ':id_ticket' => $id_ticket,
        ':bin' => $isOpen
    );

    global $connection;
    $statement = $connection->prepare($query);

    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        /*echo "<p class='centered alert alert-info col-6'>Ticket inesistente.</p>";
        echo $e;
        die();*/
        return false;
    }

    $query = "SELECT username, email, title_request FROM user INNER JOIN ticket USING(id_user) WHERE id_user = :id_user AND id_ticket = :id_ticket;";
    $values = array(
        ':id_ticket' => $id_ticket,
        ':id_user' => $idUser
    );

    global $connection;
    $statement = $connection->prepare($query);

    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        echo "<p class='centered alert alert-info col-6'>Ticket inesistente.</p>";
        echo $e;
        die();
        return false;
    }

    //username e mail dell'utente relativo al ticket
    $statement = ($statement->fetch(PDO::FETCH_ASSOC));

    if($isOpen)
        $isOpen = 'Aperto';
    else
        $isOpen = 'Chiuso';

    //blocco di script per inviare la email
    $to = $statement['email'];

    $subject = "Notifica ticket - " . $statement['title_request'];
    $message = "Buongiorno " . $statement['username'] . " lo status della tua richiesta di assistenza <b>" . $statement['title_request'] . "</b> &egrave; ora <b>" . $isOpen . "</b>. 
                <br><br>Questa email &egrave; stata inviata dal sistema automatizzato. Si prega di non rispondere.
                <br><hr><br> Fine trasmissione. <a href='http://baisiniproject.altervista.org/'>EasyLAN</a> \r\n<br>";
    $headers = "From: easylanproject@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    if (!mail($to, $subject, $message, $headers))
        return false;


    return true;
}
