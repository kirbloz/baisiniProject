<?php

@include_once('../php/function.inc.php');
@include_once('php/session.inc.php');
@include_once('session.inc.php');
class User
{
    private $id,                //id_user
        $username,          //username      
        $email;             //email

    private $firstname,
        $lastname,
        $gender,
        $birth_date,
        $address,
        $city,
        $postal_code;

    public function __construct()
    {
        $this->id = NULL;
        $this->username = NULL;
        $this->email = NULL;
        $this->firstname = NULL;
        $this->lastname = NULL;
        $this->gender = NULL;
        $this->address = NULL;
        $this->postal_code = NULL;
        $this->birth_date = NULL;
    }

    public function __destruct()
    {
    }

    //setters and getters
    public function setId($value)
    {
        $this->id = $value;
    }

    public function setUsername(string $value)
    {
        $this->username = $value;
    }

    public function setEmail(string $value)
    {
        $this->email = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        if (isset($this->firstname))
            return $this->firstname;
        else
            return "Unknown";
    }

    public function getLastname()
    {
        if (isset($this->lastname))
            return $this->lastname;
        else
            return "Unknown";
    }

    public function getGender()
    {
        if (isset($this->gender))
            return $this->gender;
        else
            return "Unknown";
    }

    public function getAddress()
    {
        if (isset($this->address))
            return $this->address;
        else
            return "Unknown";
    }

    public function getCity()
    {
        if (isset($this->city))
            return $this->city;
        else
            return "Unknown";
    }

    public function getPostalCode()
    {
        if (isset($this->postal_code))
            return $this->postal_code;
        else
            return "Unknown";
    }

    public function getBirth()
    {
        if (isset($this->birth_date))
            return $this->birth_date;
        else
            return "Unknown";
    }

    /* registrazione dell'utente nel Database */

    public function add_user($username, $pwd, $repeat_pwd, $email_address)
    {
        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true nè false potrebbe non riconoscere l'errore
        if (emptyInputSignup($username, $pwd, $email_address) !== false) {
            header('location:../signup.php?error=emptyinput');
            die();
        }

        if (invalidUserN($username) !== false) {
            header('location:../signup.php?error=invalidusername');
            die();
        }

        if (invalidEmail($email_address) !== false) {
            header('location:../signup.php?error=invalidemail');
            die();
        }

        if (invalidPwd($pwd) !== false) {
            header('location:../signup.php?error=invalidpassword');
            die();
        }

        if (pwdMatch($pwd, $repeat_pwd) !== false) {
            header('location:../signup.php?error=pwdsnotmatching');
            die();
        }

        //uso la conenssione al db, controllo se esiste già epoi procedo con il caricamento dei dati
        if (userExists($username, $email_address) !== false) {
            header('location:../signup.php?error=useralreadyexists');
            die();
        }

        if ($this->createDB($username, $pwd, $email_address) !== true) {
            header('location:../signup.php?error=queryfailed');
            die();
        }

        //ora posso inserire i valori nell'oggetto User
        //no ho deciso di inviare l'utente alla login e non mischiare le cose

        //rimando l'utente alla pagina di signup con il codice corretto
        header('location:../signup.php?error=none&username=' . $username);
        die();
    }

    public function login_user($username, $pwd)
    {

        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
        //nè false potrebbe non riconoscere l'errore
        if (emptyInputLogin($username, $pwd) !== false) {
            header('location:../login.php?error=emptyinput');
            die();
        }

        if ($this->loginDB($username, $pwd) !== true) {
            header('location:../login.php?error=queryfailed');
            die();
        }

        //a questo punto ho effettuato il login e posso popolare l'oggetto user
        $this->setEverything($username, false);
        return $this->id;
        //fine script e si ritorna a login.inc.php
    }


    public function getUserTuple($uid, bool $session)
    {
        global $connection;
        //se $session è true, allora uid viene interpretato come la PK della sessione
        if ($session) {
            $session = getSessionTuple(session_id());
            $result = userExists($session['username'], $session['username']);
        } else
            $result = userExists($uid, $uid);

        if ($result === false) {
            header('location:../login.php?error=nouser');
            die();
        } else
            return $result;
    }

    public function setEverything($uid, bool $session)
    {
        $values = $this->getUserTuple($uid, $session);
        if (!is_array($values)) {
            header('location:../login.php?error=queryfailed');
            die();
        }
        $this->id = $values['id_user'];
        $this->username = $values['username'];
        $this->email = $values['email'];
    }

    public function add_Customer(array $values)
    {
        //controllo che non esista il customer, anche se avviene già in un altra pagina, ma tengo il controllo lato server in ogni caso
        if (!($this->setCustomer() === false)) //false solo se non c'è una tupla
            header('location:../userShowcase.php');

        //preparo la query
        $query = "INSERT INTO customer(id_user, firstname, lastname, gender, address, city, postal_code, birth_date) VALUES(:id_user, :firstname, :lastname, :gender, :address, :city, :postal_code, :birth_date)";

        //faccio il controllo sull'input
        if (invalidUserN($values['firstname']) !== false) {
            echo '<p class="alert alert-danger">Nome non valido.</p>';
            return 0;
        }

        if (invalidUserN($values['lastname']) !== false) {
            echo '<p class="alert alert-danger">Cognome non valido.</p>';
            return 0;
        }

        if ($values['address'] == "")
            $values['address'] = NULL;
        if ($values['city'] == "")
            $values['city'] = NULL;
        if ($values['postal_code'] == "")
            $values['postal_code'] = NULL;
        if (strlen($values['postal_code']) > 5)
            $values['postal_code'] = NULL;
        if ($values['birth_date'] == "")
            $values['birth_date'] = NULL;

        //e preparo l'array di valori
        $values = array(
            ':id_user' => $this->id,
            ':firstname' => $values['firstname'],
            ':lastname' => $values['lastname'],
            ':gender' => $values['gender'],
            ':address' => $values['address'],
            ':city' => $values['city'],
            ':postal_code' => $values['postal_code'],
            ':birth_date' => $values['birth_date']
        );

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            //return false;
            var_dump($statement);
            echo $e;
            die();
        }

        $this->setCustomer();
        //rimando l'utente alla pagina userShowcase con il codice corretto
        header('location:../userShowcase.php?add=customer&error=none');
    }

    public function update_Customer(array $newvalues)
    {
        if (invalidUserN($newvalues['firstname']) !== false) {
            echo '<p class="alert alert-danger">Nome non valido.</p>';
            return 0;
        }

        if (invalidUserN($newvalues['lastname']) !== false) {
            echo '<p class="alert alert-danger">Cognome non valido.</p>';
            return 0;
        }
        //preparo la query
        $query = "UPDATE customer SET firstname = :firstname, lastname = :lastname, gender = :gender, address = :address, city = :city, postal_code = :postal_code, birth_date = :birth_date WHERE id_user = :id_user";

        if ($newvalues['gender'] == "")
            $newvalues['gender'] = NULL;
        if ($newvalues['address'] == "")
            $newvalues['address'] = NULL;
        if ($newvalues['city'] == "")
            $newvalues['city'] = NULL;
        if ($newvalues['postal_code'] == "")
            $newvalues['postal_code'] = NULL;
        if ($newvalues['birth_date'] == "")
            $newvalues['birth_date'] = NULL;

        //e preparo l'array di valori
        $values = array(
            ':id_user' => $this->id,
            ':firstname' => $newvalues['firstname'],
            ':lastname' => $newvalues['lastname'],
            ':gender' => $newvalues['gender'],
            ':address' => $newvalues['address'],
            ':city' => $newvalues['city'],
            ':postal_code' => $newvalues['postal_code'],
            ':birth_date' => $newvalues['birth_date']
        );
        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
            /*var_dump($statement);
            var_dump($values);
            die();*/
        } catch (PDOException $e) {
            //return false;
            var_dump($statement);
            echo $e;

            die();
        }

        $this->setCustomer();
        //rimando l'utente indietro con il codice corretto
        echo "<p class='centered alert alert-info'>Informazioni salvate corretamente. <b><a href='userShowcase.php'>Aggiorna qui la pagina</a></b></p>";
        die();
    }

    public function setCustomer()
    {
        global $connection;
        //preparo la query
        $query = "SELECT * FROM customer WHERE id_user = :id_user";
        if (!isset($this->id))
            header('location:logout.inc.php');
        $values = array(':id_user' => $this->id);

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            //errore
            return false;
        }


        //controllo se effettivamente ho una query e proseguo
        if ($statement->rowCount() > 0) {
            $statement = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            //no tupla, non esiste il customer di questo utente
            return false;
        }

        //si tupla, esiste il customer, assegno e poi ritorno true
        $this->firstname = $statement['firstname'];
        $this->lastname = $statement['lastname'];
        $this->gender = $statement['gender'];
        $this->birth_date = $statement['birth_date'];
        $this->address = $statement['address'];
        $this->city = $statement['city'];
        $this->postal_code = $statement['postal_code'];
        return true;
    }

    public function changePWD(string $pwd, string $repeat_pwd)
    {
        //includo per la connessione
        require_once('../db/databasehandler.inc.php');

        //controllo non necessario perchè lo faccio già in logout.inc
        /*if(emptyInputLogin($repeat_pwd, $pwd) !== false){
            header('location:userShowcase.php?redirect=changepwd&error=invalidinput');
        }*/

        //controllo che la pwd non sia uguale
        $uid_result = $this->getUserTuple($this->username, false);

        //se la password fornita è diversa da quella nel db ti rimando indietro
        if (password_verify($pwd, $uid_result['password']) === true) {
            header('location:../userShowcase.php?redirect=changepwd&error=samepwd');
        }

        //controllo che la pwd sia valida e matchi
        if (invalidPwd($pwd) !== false) {
            header('location:../userShowcase.php?redirect=changepwd&error=invalidinput');
            die();
        }

        if (pwdMatch($pwd, $repeat_pwd) !== false) {
            header('location:../userShowcase.php?redirect=changepwd&error=nomatch');
            die();
        }

        //inserisco la nuova pwd nel db
        $query = "UPDATE user SET password = :pwd_hash WHERE id_user = :id_user;";

        //crypto la password e preparo l'array di valori
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $values = array(
            ':id_user' => $this->id,
            ':pwd_hash' => $pwd
        );

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            //return false;
            var_dump($statement);
            echo $e;
            die();
        }
        //tutto a posto, lo script ritorna in logout.inc.php e andrà in logout.php
    }

    public function saveTicket(array $form)
    {
        if (empty($this->email)) {
            echo "<p class='centered alert alert-info'>Email non valida. Controlla i tuoi dati dalla tua area utente.</p>";
            return false;
        }
        date_default_timezone_set('Europe/Rome');
        $query = "INSERT INTO ticket(id_user, title_request, description, image, date) VALUES(:id_user, :title_request, :description, :image, :date)";
        $values = array(
            ':id_user' => $this->getId(),
            ':title_request' => $_POST['title_request'],
            ':description' => $_POST['description'],
            ':image' => NULL,
            ':date' => date('Y-m-d')
        );

        global $connection;
        $statement = $connection->prepare($query);

        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            /*var_dump($statement);
            echo "<p class='centered error'>Errore nell'esecuzione della query</p> " . $e;
            die();*/
            return false;
        }

        if (!$statement) //errore
            return false;

        //blocco di script per inviare la email
        $to = (string) $this->email;

        $subject = "Conferma invio ticket - " . $_POST['title_request'];
        $message = "Buongiorno " . $this->getFirstname() . " la tua richiesta di assistenza <b>" . $_POST['title_request'] . "</b> &egrave; stata ricevuta.
        <br>Uno dei nostri tecnici si occuper&agrave; di te al prima possibile con una email all'indirizzo specificato nelle informazioni del tuo profilo!
        <br><br>Questa email &egrave; stata inviata dal sistema automatizzato. Si prega di non rispondere.
        <br><hr><br>" . $_POST['description'] . "<br> Fine trasmissione. <a href='http://baisiniproject.altervista.org/'>EasyLAN</a> ";
        $headers = "From: easylanproject@gmail.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        if (!mail($to, $subject, $message, $headers))
            return false;
        return true;
    }

    public function showTicket()
    {
        date_default_timezone_set('Europe/Rome');
        $query = "SELECT * FROM ticket WHERE id_user = :id_user";
        $values = array(
            ':id_user' => $this->getId()
        );

        global $connection;
        $statement = $connection->prepare($query);
        //se query multiple prepara prima e poi fai nel for con i rispetti values
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            echo "<p class='centered alert alert-info'>Nessun ticket trovato.</p>";
            echo $e;
            //die();
        }

        if ($statement->rowCount() > 0) {

            echo "Nel database sono presenti " . $statement->rowCount() . " tickets.<br><br>";
            $arrayTicket = ($statement->fetchAll(PDO::FETCH_ASSOC));
            //var_dump($arrayTicket);
            if ($arrayTicket == false)
                echo "<p class='centered error'>Errore nell'esecuzione della query</p>";
            else {
                $tot = 0;
                //inizio la stampa della tabella

                foreach ($arrayTicket as $row) {
                    $orario = strtotime($row['date']);
                    if ($row['isOpen'])
                        $status = 'Aperto';
                    else
                        $status = 'Chiuso';

                    echo "<div class='container ticket' >";
                    echo "<div class='row '>";
                    echo "<div class='col-sm-4 m-1'><b>ID Ticket:</b> " . $row['id_ticket'] . "</div>";
                    echo "<div class='col-sm-4 m-1'>Titolo: " . $row['title_request'] . "</div>";
                    echo "<div class='col-sm-4 m-1'>Data: " . date('d-m-Y', $orario) . "</div>";
                    echo "<div class='col-sm-4 m-1'>Status: " . $status . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='col m-1'><b>Contenuto:</b> " . $row['description'] . "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                }
            }
        } else if (!$statement) //errore
            echo "<p class='centered error'>Errore nell'esecuzione della query, riprova più tardi.</p>";
        else
            echo "<p class='centered alert alert-info'>Nessun ticket trovato</p><br><br><br>";
    }

    /*public function saveWork()
    {
        echo "funzione fittizia da rimuovere.";
    }*/

    public function showWork()
    {
        date_default_timezone_set('Europe/Rome');
        $query = "SELECT work.* FROM work INNER JOIN customer USING (id_customer) WHERE id_user = :id_user";
        $values = array(
            ':id_user' => $this->getId()
        );

        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            echo "<p class='centered alert alert-info col-6'>Nessun intervento programmato trovato.</p>";
        }

        if ($statement->rowCount() > 0) {

            $arrayWork = ($statement->fetchAll(PDO::FETCH_ASSOC));
            if ($arrayWork == false)
                echo "<p class='centered alert alert-danger col-6'>Errore nell'esecuzione della query</p>";
            else {
                $tot = 0;
                //inizio la stampa della tabella
                //formatto i campi DATE se isset
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
            echo "<p class='centered alert alert-danger col-6'>Errore nell'esecuzione della query, riprova più tardi.</p>";
        else
            echo "<p class='centered alert alert-info col-6'>Nessun intervento trovato</p><br><br><br>";
    }

    private function loginDB($uid, $pwd)
    {
        //controllo che l'utente cerchi di loggare un account che esiste effettivamente
        //se l'utente esiste ne ho già salvate le credenziali nella variabile
        $uid_result = $this->getUserTuple($uid, false);

        //se la password fornita è diversa da quella nel db ti rimando indietro
        if (password_verify($pwd, $uid_result['password']) === false) {
            header('location:../login.php?error=wrongpassword');
            die();
        } else if (password_verify($pwd, $uid_result['password']) === true) {
            return true;
        }
        echo "no";
        die();
    }

    private function createDB($username, $pwd, $email_address)
    {
        //preparo la query
        $query = "INSERT INTO user( username, password, email) VALUES(:username, :password, :email_address)";

        //crypto la password e preparo l'array di valori
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $values = array(
            ':username' => $_POST['username'],
            ':password' => $pwd,
            ':email_address' => $_POST['email_address']
        );
        global $connection;
        $statement = $connection->prepare($query);
        try {
            $statement->execute($values);
        } catch (PDOException $e) {
            //return false;
            var_dump($statement);
            echo $e;

            die();
        }

        return true;
    }

    public function logout_user()
    {
        deleteSessionTuple(session_id());
        $this->__destruct();
    }
}