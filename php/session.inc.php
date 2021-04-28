<?php
session_start();
require_once('function.inc.php');
//require_once('../classes/User.php');

//controllo che esista una sessione, se non esiste invio a login.php
//se esiste ma è scaduta invio all'index e distruggo la sessione

function checkActive($redirect){
    //AVERE $REDIRECT=FALSE E' PERICOLOSO PERCHE' NON RIMANDA INDIETRO L'UTENTE, 
    //FARE CONTROLLO OGNI VOLTA CHE SI RICHIAMA CHECK SENZA REDIRECT

    if(!isset($_SESSION['idSession'])){
        //se start time non c'è faccio redirect oppure ritorno false
        if($redirect){
            header('Location:../login.php');
            die;
        }
        //ritorno che la sessione non c'è
        return false;

    }else{
        //se c'è start time allora controllo che non sia scaduta
        //se serve redirect lo faccio solo in caso di logout
        $now = time();
        require('../db/databasehandler.inc.php');
        //preparo la query

        $query = "SELECT * FROM session WHERE id_session = :id";
        $values = array(':id'=> $_SESSION['idSession']);
        $statement = $connection->prepare($query);
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            //return false;
            var_dump($statement);
            echo $e;
            die();
        }
        $tuple=$statement->fetch(PDO::FETCH_ASSOC);
        $duration = $now - $tuple['start_time'];
        if($duration > 600){ //se è da più di un ora, logout
                if($redirect){
                    header('Location:php/logout.inc.php');
                    die;
                    //lascio fare tutto il log out alla sua pagina, in caso di sessione scaduta
                    //l'unica opzione è SEMPRE log out, lì dovrò distruggere la sessione
                    //etc
                }
            //ritorno che la sessione non c'è
            return false;
        }
        //ritorno che la sessione c'è ed è valida
        //in caso vada tutto bene, c'è una sessione valida, non ha senso il redirect 
        if(!$redirect)
            return true;
    }
}

//creo una sessione partendo dall'id dell'utente sputato fuori dalla ricerca di un utente valido con cui confrontare le credenziali di login
function createSession($connection, $username){
    
    $uid_result = getUserTuple($connection, $username, false);
    //cancello query contenenti altre sessioni
    if(checkActive(false))
        deleteSessionTuple($connection, $uid_result['username']);
    
    /*var_dump($statement);
    echo "ok";
    die();*/

    //preparo la query
    $query = "INSERT INTO session(start_time, id_user) VALUES(:start_time, :id_user)";
    $values = array(
        ':id_user'=> $uid_result['id_user'],
        ':start_time' => time()
    );
    $statement = $connection->prepare($query);
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        //return false;
        var_dump($statement);
        echo $e;
        $connection = null;
        die();
    }

    //salvo nella tab sessioni
    try{
        startSession($uid_result);
    }catch(Exception $e){
        //echo $e;
        header('location:../login.php?error=sessionfailed');
        die();
    }
    return $uid_result;
}                   

function deleteSessionTuple(int $id){
    require('../db/databasehandler.inc.php');
    $query = "DELETE FROM session WHERE id_user = :id_user";
    $values = array(':id_user'=> $id);
    $statement = $connection->prepare($query);
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        //return false;
        var_dump($statement);
        echo $e;
        die();
    }

}

function startSession($uid_result){
    //aggiungere funzione per salvare anche i dati customer
    session_start();
    session_unset();
    session_destroy();
    //creo
    session_start();
    $_SESSION['idSession'] = $uid_result['id_user'];
    /*$_SESSION['userOBJ'] = $utente;

    $utente->setId($uid_result['id_user']);
    $utente->setEmail($uid_result['email']);
    $utente->setUsername($uid_result['username']);*/

}

function stopSession(int $id){
    deleteSessionTuple($id);
    try{
        session_start();
        session_unset();
        session_destroy();
    }catch(Exception $e){
        echo $e;
    }
}


function getSessionTuple($id){
    require('../db/databasehandler.inc.php');
    $query = "SELECT id_user, id_session, start_time, username, email FROM session INNER JOIN user USING(id_user) WHERE id_session = :id OR id_user = :id";
    $values = array( ':id'=> $id);
    
    $statement = $connection->prepare($query);
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        //return false;
        var_dump($statement);
        echo $e;
        
        die();
    }

    //se trovo una sessione allora restituisco la tupla
    if($statement->rowCount() > 0 && $statement->rowCount() < 2){
        return $statement->fetch(PDO::FETCH_ASSOC);
    }else{
        //var_dump($statement);
        header('location:../logout.inc.php');
        die();
    }
}