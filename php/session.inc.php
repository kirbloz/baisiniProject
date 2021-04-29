<?php
include('../db/databasehandler.inc.php');
include('db/databasehandler.inc.php');



//controlla che ci sua una sessione solo in caso io abbia
function checkActive(){
    if(session_status() == PHP_SESSION_ACTIVE){
        //controllo che effettivamente ci sia una sessione nel db
        $query = "SELECT * FROM session WHERE id_session = :id_session";
        $values = array(':id_session' => session_id());

        global $connection;
        //preparo query
        $statement = $connection->prepare($query);
        try {
            //eseguo query
            $statement->execute($values);
        } catch (PDOException $e) {
            header('location:../login.php?=queryfailed');
            die();
        }

        //fetch 
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
        if(is_array($statement))
            return true;
    }
    return false;
}

function createSession(int $id){
    //cancello query contenenti altre sessioni
    if(checkActive()){
        deleteSessionTuple($id);
    }
    session_start();
    if(session_id() == NULL || session_id() == "" || session_id() == false)
        if(!session_regenerate_id())
        return false;
            

    //preparo la query
    $query = "INSERT INTO session(id_session, start_time, id_user) VALUES(:id_session, :start_time, :id_user)";
    $values = array(
        ':id_session' => session_id(),
        ':id_user'=> $id,
        ':start_time' => time()
    );
    global $connection;
    //preparo query
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
    return true; //tutto ok
}

function deleteSessionTuple(int $id){

    $query = "DELETE FROM session WHERE id_user = :id_user";
    $values = array(':id_user'=> $id);

    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        //return false;
        var_dump($statement);
        echo $e;
        die();
    }

    try{
        session_start();
        session_unset();
        session_destroy();
    }catch(Exception $e){
        echo $e;
        die();
    }
}

function getSessionTuple($id){
    $query = "SELECT id_user, id_session, start_time, username, email FROM session INNER JOIN user USING(id_user) WHERE id_session = :id OR id_user = :id";
    $values = array( ':id'=> $id);
    
    global $connection;
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