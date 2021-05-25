<?php
@include_once('../db/databasehandler.inc.php');
@include_once('db/databasehandler.inc.php');



//controlla che ci sua una sessione solo in caso io abbia
function checkActive()
{
    @session_start();

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

    //se il risultato non è un errore, guardo la sessione e controllo che sia valida
    if ($statement == false)
        return false;

    if ($statement->rowCount() > 0) {
        //fetch 
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
        if (is_array($statement))
            if (time() - $statement['start_time'] < 3600) {
                return true;
            } else {
                return false;
            }
    }

    return false;
}



function checkActiveSuper()
{
    @session_start();
    //controllo che effettivamente ci sia una sessione nel db
    $query = "SELECT * FROM supersession WHERE id_supersession = :id_session";
    $values = array(':id_session' => session_id());

    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try {
        //eseguo query
        $statement->execute($values);
    } catch (PDOException $e) {
        header('location:../superlogin.php?=queryfailed');
        die();
    }

    //se il risultato non è un errore, guardo la sessione e controllo che sia valida
    if ($statement == false)
        return false;

    if ($statement->rowCount() > 0) {
        //fetch 
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
        if (is_array($statement))
            if (time() - $statement['start_time'] < 3600) {
                return true;
            } else {
                return false;
            }
    }

    return false;
}

//questo id è quello dell'user
function createSession($id)
{
    //cancello query contenenti altre sessioni
    //controllo di non avere tuple residue
    @session_start();

    if (checkActive())
        deleteSessionTuple($id);

    $query = "DELETE FROM session WHERE id_user = :id_user OR id_session = :id_session";

    $values = array(
        ':id_user' => $id,
        ':id_session' => session_id()
    );
    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try {
        //eseguo query
        $statement->execute($values);
    } catch (PDOException $e) {
        header('location:../login.php?error=queryfailed');
        die();
    }

    @session_start();
    if (session_id() == NULL || session_id() == "" || session_id() == false)
        if (!session_regenerate_id())
            return false;


    //preparo la query
    $query = "INSERT INTO session(id_session, start_time, id_user) VALUES(:id_session, :start_time, :id_user)";
    $values = array(
        ':id_session' => session_id(),
        ':id_user' => $id,
        ':start_time' => time()
    );
    //preparo query
    $statement = $connection->prepare($query);
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        //return false;
        var_dump($statement);
        echo $e;
        $connection = null;
        die();
    }
    return true; //tutto ok
}

function createSupersession($id)
{
    //cancello query contenenti altre sessioni
    //controllo di non avere tuple residue
    @session_start();

    //controllo che effettivamente ci sia una sessione nel db
    $query = "SELECT * FROM supersession WHERE id_supersession = :id_session AND id_superuser = :id";
    $values = array(
        ':id_session' => session_id(),
        ':id' => $id
    );
    //var_dump($id);
    //die();
    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try {
        //eseguo query
        $statement->execute($values);
    } catch (PDOException $e) {
        header('location:../superlogin.php?=queryfailed');
        die();
    }

    if ($statement != false)
        deleteSupersessionTuple($id);

    /*$query = "SELECT * FROM supersession WHERE id_supersession = :id_supersession";

    //$id può essere sia id superuser che supersession
    $values = array(':id_supersession'=> $id);

    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try {
        //eseguo query
        $statement->execute($values);
    } catch (PDOException $e) {
        echo $e;
        //header('location:../superlogin.php?error=queryfailed');
        die();
    }
    //fetch 
    $statement = $statement->fetch(PDO::FETCH_ASSOC);

    var_dump($statement);
    die();
    if($statement !== false)
        if($statement->rowCount() > 0)
            deleteSupersessionTuple($statement['id_supersession']);

    $statement = NULL;*/

    @session_start();
    if (session_id() == NULL || session_id() == "" || session_id() == false)
        if (!session_regenerate_id())
            return false;

    global $connection;
    //preparo la query
    $query = "INSERT INTO supersession(id_supersession, start_time, id_superuser) VALUES(:id_supersession, :start_time, :id_superuser)";
    $values = array(
        ':id_supersession' => session_id(),
        ':id_superuser' => $id,
        ':start_time' => time()
    );

    //preparo query
    $statement = $connection->prepare($query);
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        //return false;
        var_dump($statement);
        echo $e;
        $connection = null;
        die();
    }
    return true; //tutto ok
}

function deleteSessionTuple($id)
{
    $query = "DELETE FROM session WHERE id_user = :id_user OR id_session = :id_session";
    if (!is_int($id))
        $num = 0;
    else
        $num = $id;

    $values = array(
        ':id_user' => $num,
        ':id_session' => $id
    );

    global $connection;
    //preparo query
    $statement = $connection->prepare($query);
    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        /*echo $e;
        die();*/
        header("location:index.php");
    }

    try {
        @session_start();
        session_unset();
        session_destroy();
    } catch (Exception $e) {
        echo $e;
        die();
    }
}

//$id può essere l'id del superutente oppure sid ((super)session id)
function deleteSupersessionTuple($id)
{
    $query = "DELETE FROM supersession WHERE id_superuser = :id_superuser OR id_supersession = :id_session";
    /*if(is_string($id))
        $num = 0;
    else   */
    $num = $id;
    $values = array(
        ':id_superuser' => (int) $id,
        ':id_session' => (string) $num
    );

    global $connection;
    $statement = $connection->prepare($query);

    try {
        $statement->execute($values);
    } catch (PDOException $e) {
        /*echo $e;
        die();*/
        header("location:index.php");
    }

    try {
        @session_start();
        session_unset();
        session_destroy();
    } catch (Exception $e) {
        echo $e;
        die();
    }
}

//$id può essere l'id del superutente oppure sid ((super)session id)
function getSupersessionTuple($id)
{
    $query = "SELECT id_superuser, id_supersession, start_time, id_technician, email FROM supersession INNER JOIN superuser USING(id_superuser) WHERE id_supersession = :id OR id_superuser = :id";
    $values = array(':id' => $id);

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
    //se trovo una sessione allora restituisco la tupla
    if ($statement->rowCount() > 0 && $statement->rowCount() < 2) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        //var_dump($statement);
        header('location:../logout.php?error=nosession');
        die();
    }
}

function getSessionTuple($id)
{
    $query = "SELECT id_user, id_session, start_time, username, email FROM session INNER JOIN user USING(id_user) WHERE id_session = :id OR id_user = :id";
    $values = array(':id' => $id);

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
    //se trovo una sessione allora restituisco la tupla
    if ($statement->rowCount() > 0 && $statement->rowCount() < 2) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        //var_dump($statement);
        header('location:../logout.php?error=nosession');
        die();
    }
}
