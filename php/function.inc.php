<?php

//include_once('db/databasehandler.inc.php');

function emptyInputSignup($username, $pwd, $email_address){
    
    $result = null;
    if(empty($username) || empty($pwd) || empty($email_address))
        $result = true;
    else
        $result = false;
    return $result;
}

function emptyInputLogin($username, $pwd){
    
    $result = null;
    if(empty($username) || empty($pwd))
        $result =true;
    else
        $result = false;
    return $result;
}

function invalidUserN($username){
    $result=null;
    if(strlen($username)>20 || preg_match("[@_!#$%^&*()<>?-/|}{~:;=^]", $username))
        $result=true;
    else
        $result=false;
    return $result;
}

function invalidEmail($email_address){

    $result=null;
    if(!filter_var($email_address, FILTER_VALIDATE_EMAIL))
        $result=true;
    else
        $result=false;
    return $result;
}

function invalidPwd($pwd){

    $result=null;
    if(strlen($pwd) > 20 || strlen($pwd) < 8)
        $result=true;
    else
        $result=false;
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){

    $result=null;
    if($pwd !== $pwdRepeat)
        $result=true;
    else
        $result=false;
    return $result;
}

function userExists($connection, $username, $email_address){
    $values=array();

    //preparo la query per la ricerca e l'array per i valori
    $query = "SELECT * FROM user WHERE username = :username OR email = :email_address;";
    $values[':username'] = $username;
    $values[':email_address'] = $email_address;
    $statement = $connection->prepare($query);

    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        $connection = null;
        header('location:../signup.php?error=queryfailed');
        die();
    }

    if($statement->rowCount() > 0){
        //ritorno l'array con index i nomi delle colonne
        $connection = null;
        return $statement->fetch(PDO::FETCH_ASSOC);
    }else{
        $connection = null;
        return false;
    }
}

//spostare queste funzioni nella classe User
function createUser($connection, $username, $pwd, $email_address){

    //preparo la query
    $query = "INSERT INTO user( username, password, email) VALUES(:username, :password, :email_address)";
    
    //crypto la password e preparo l'array di valori
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    $values = array(
        ':username'=> $_POST['username'],
        ':password' => $pwd,
        ':email_address' => $_POST['email_address']
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
    $connection = null;
    return true;
}

function loginUser($connection, $uid, $pwd){

    //controllo che l'utente cerchi di loggare un account che esiste effettivamente
    //se l'utente esiste ne ho già salvate le credenziali nella variabile
    $uid_result = userExists($connection, $uid, $uid);
    if( $uid_result == false){
        header('location:../login.php?error=nouser');
        die();
    }

    //se la password fornita è diversa da quella nel db ti rimando indietro
    if(password_verify($pwd, $uid_result['password']) === false){
        header('location:../login.php?error=wrongpassword');
        die();
    }else if(password_verify($pwd, $uid_result['password']) === true){
        //1.44.36
        //fare le sessioni SI POTREBBE SALVARE UN VALORE ISLOGGEDIN IN $SESSION PER DIRE ALLA CLASSE SESSION CHE PUO INSERIRE LA TUPLA SENZA PROBLEMI
        createSession($connection, $uid_result['id_user']);
        $connection = null;
        return true;

    }
    
    echo "no";
    die();
}

function createSession($connection, $iduser){

    //preparo la query
    $query = "INSERT INTO session(start_time, id_user) VALUES(:start_time, :id_user)";
    //
    //  DECIDERE QUANDO ISTANZIARE LA CLASSE RISPETTO A QUANDO CREO LA TUPLA, FARE UNA COSA FATTA BENE
    //
    // $values = array(
    //     ':start_time'=> ,
    //     ':id_user' => $iduser
    // );
    
    $statement = $connection->prepare($query);
    try{
        $statement->execute();
    }catch(PDOException $e){
        //return false;
        var_dump($statement);
        echo $e;
        $connection = null;
        die();
    }

    $connection = null;

}