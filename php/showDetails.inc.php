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
        $values[':matricola'] = $_GET['matricola'];

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
        */
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
    

    

    