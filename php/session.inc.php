<?php

require_once('function.inc.php');
//require_once('../classes/User.php');

//controllo che esista una sessione, se non esiste invio a login.php
//se esiste ma è scaduta invio all'index e distruggo la sessione

function check($redirect){
    //AVERE $REDIRECT=FALSE E' PERICOLOSO PERCHE' NON RIMANDA INDIETRO L'UTENTE, 
    //FARE CONTROLLO OGNI VOLTA CHE SI RICHIAMA CHECK SENZA REDIRECT
    session_start();
    //var_dump($_SESSION);
    //die();
    if(!isset($_SESSION['isStarted'])){
        //se start time non c'è faccio redirect oppure ritorno false
        if($redirect){
            header('Location:login.php');
            die;
        }
        //ritorno che la sessione non c'è
        return false;

    }else{
        //se c'è start time allora controllo che non sia scaduta
        //se serve redirect lo faccio solo in caso di logout
        $now = time();
        $duration = $now - $_SESSION['start_time'];
        if($duration > 30){ //se è da più di un ora, logout
                if($redirect){
                    header('Location:logout.php');
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
    
    $uid_result = getUserTuple($connection, $username);
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
    return $uid_result;
    // lo script ritorna in user->login_user
    //
    //           AGGIUNGERE CONTROLLO SESSIONI GIA' PRESENTI
    //              PRIMA DEL LOGIN E IN CONCOMITANZA
    //                          FARE IL LOGOUT
}                   

function startSession(User $utente, array $uid_result){

    //aggiungere funzione per salvare anche i dati customer
    session_start();
    session_unset();
    session_destroy();
    //creo
    session_start();
    $_SESSION['isStarted'] = true;
    $_SESSION['userOBJ'] = $utente;

    $utente->setId($uid_result['id_user']);
    $utente->setEmail($uid_result['email']);
    $utente->setUsername($uid_result['username']);

}