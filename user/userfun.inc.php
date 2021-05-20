<?php


function printTicketArea(User $utente)
{
    echo '<div class="wrapper user-area ">
        <br>

        <div class="row">
            <div class="color-lightb user-nav col">
                <ul>
                    <li><a href="areaUtente.php">Torna indietro</a></li>
                    <li><a href="userfetch.php?select=tickets&show=true">Visualizza i tuoi ticket</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="wrapper user-info" style="text-align:left;">

        <div class="row">';
    //var_dump($_POST);
    /*
        posso accedere all'area ticket solo se sono un customer, perchè necessito di più dati
    */

    if ($utente->setCustomer() == true) {

        if (isset($_POST['submit'])) {
            //controllo la compilazione del form
            if (empty($_POST['description']) || empty($_POST['title_request'])) {
                echo "<p class='centered error'>Compila tutti i campi.</p>";
            } else {
                //procedo con il salvataggio e invio mail del ticket
                if ($utente->saveTicket($_POST))
                    echo "<p class='centered alert alert-info'>Ticket inviato con successo.</p>";
                else
                    echo "<p class='centered alert alert-info'>Non è stato possibile completare la richiesta. Riprova più tardi.</p>";
            }
        } else if (isset($_GET) && isset($_GET['show'])) {
            //se non c'è stato un submit, controllo se è stato premuto il tasto di visione dei ticket
            $utente->showTicket();
        }

        //print elementi html per la prima parte del form
        echo '</div>
        <br>
        <div class="row">
            <div class="container">
                <div class="col">Compila i campi sottostanti per inviare un ticket via email alla nostra assistenza.</div>
            </div>
        </div>
        <br>
        <div class="row">
            <form action="" method="post">
    
                <div class="row g-3">
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="title_request" placeholder="Titolo">
                    </div>
                    <div class="col-sm" style="text-align:left; padding-top:5px;">';

        //formatto l'orario con l'ausilio di una variabile 
        date_default_timezone_set('Europe/Rome');
        $orario = date('m/d/Y H:i:s');
        echo $orario;

        //print elementi html per la seconda parte del form
        echo        '</div>
                </div>
    
                <div class="row g-3">
                    <div class="form-group">
                        <label for="request">Inserisci qui la tua richiesta:</label>
                        <textarea name="description" class="form-control rounded-25" id="request" rows="5" max-rows="8"></textarea>
                    </div>
                </div>
    
                <input type="submit" class="btn btn-primary" name="submit" value="Invia" style="margin-top:5px;">
            </form>
        </div>
        </div>';
    }else{
    echo    '<div class="row">
            <p class="centered alert alert-warning">Non &egrave; stato possibile completare la richiesta perch&egrave; non sei registrato come Cliente. Puoi farlo <a href="signupCustomer.php">qui</a>.</p>
        </div>';
    }
}



function printWorkArea(User $utente)
{
    echo '<div class="wrapper user-area ">
        <br>

        <div class="row">
            <div class="color-lightb user-nav col">
                <ul>
                    <li><a href="areaUtente.php">Torna indietro</a></li>
            </div>
        </div>
    </div>

    <div class="wrapper user-info" style="text-align:left;">

        <div class="row">';
    //var_dump($_POST);
    if (isset($_POST['submit'])) {
        //controllo la compilazione del form
        if (empty($_POST['description']) || empty($_POST['title_request'])) {
            echo "<p class='centered error'>Compila tutti i campi.</p>";
        } else {
            //procedo con il salvataggio e invio mail del ticket
            if ($utente->saveWork($_POST))
                echo "<p class='centered alert alert-info'>Ticket inviato con successo.</p>";
            //echo "<p class='centered alert alert-info'>Non è stato possibile completare la richiesta. Riprova più tardi.</p>";

        }
    } else /*if (isset($_GET) && isset($_GET['show'])) */ {
        //se non c'è stato un submit, controllo se è stato premuto il tasto di visione dei ticket
        $utente->showWork();
    }
}

function fetchidUser()
{
    //preparo la query per la ricerca e l'array per i valori
    echo "</div><div class='wrapper'><h4>Informazioni cliente</h4><hr>";
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
                <form class="form-horizontal" method="post" action="userShowcase.php">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                IdUser:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="" placeholder="' .htmlentities($statement['id_user']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Nome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="firstname" value="' .htmlentities($statement['firstname']) .'" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Cognome:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="lastname" value="' .htmlentities($statement['lastname']) .'" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Username:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="username" placeholder="' .htmlentities($statement['username']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Email:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="email" placeholder="' .htmlentities($statement['email']) .'" disabled> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Data di nascita:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="birth_date" value="' .htmlentities($statement['birth_date']) .'" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Genere:
                            </div>
                            <div class="col-sm-4" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="gender" value="' .htmlentities($temp) .'"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Citt&agrave;:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="city" value="' .htmlentities($statement['city']) .'" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                Indirizzo:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="address" value="' .htmlentities($statement['address']) .'"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                CAP:
                            </div>
                            <div class="col-sm-7" style="text-align:left; margin:5px;">
                                <input type="text" class="form-control" name="postal_code" value="' .htmlentities($statement['postal_code']) .'"> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-primary" name="submit" value="Salva">
                                <span></span>
                                <input type="reset" class="btn btn-default" value="Reset">
                                </form>
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