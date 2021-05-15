<?php

@include_once('../db/databasehandler.inc.php');
@include_once('db/databasehandler.inc.php');

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

function userExists($username, $email_address){
    $values=array();

    //preparo la query per la ricerca e l'array per i valori
    $query = "SELECT * FROM user WHERE username = :username OR email = :email_address;";
    $values[':username'] = $username;
    $values[':email_address'] = $email_address;

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        header('location:../signup.php?error=queryfailed');
        die();
    }


    if($statement->rowCount() > 0){
        //ritorno l'array con index i nomi delle colonne
        
        return $statement->fetch(PDO::FETCH_ASSOC); 
        //questa query restituisce l'array con la tupla dell'utente, utile
        //var_dump($statement->fetch(PDO::FETCH_ASSOC));
        //die();
    }else{
        
        return false;
    }
}

function superuserExists($matricola){
    $values=array();

    //preparo la query per la ricerca e l'array per i valori
    $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :matricola;";
    $values[':matricola'] = $matricola;

    global $connection;
    $statement = $connection->prepare($query);
    
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        header('location:../superlogin.php?error=queryfailed');
        //echo "superuserexist";
        die();
    }


    if($statement->rowCount() > 0){
        return $statement->fetch(PDO::FETCH_ASSOC); 
        //questa query restituisce l'array con la tupla dell'utente, utile
        //var_dump($statement->fetch(PDO::FETCH_ASSOC));
        //die();
    }else{
        return false;
    }
}

function deleteUserTuple(){
    @session_start();
    //preparo la query per la ricerca e l'array per i valori
    $utente = generateUserOBJ(session_id());

    $query = "DELETE FROM user WHERE id_user = :id_user";
    $values[':id_user'] = $utente->getId();

    global $connection;
    $statement = $connection->prepare($query);
    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        var_dump($statement);
        echo $e;
        return false;
    }

    //fine script, ritorna in logout.inc.php
    return true;
}

function generateUserOBJ(string $sid){
    @include_once('../classes/User.php');
    @include_once('classes/User.php');

    $temp = new User();
    $temp->setEverything($sid, true);
    //var_dump($temp);
    return $temp;
}

function generateSuperuserOBJ(string $sid){
    @include_once('../classes/Superuser.php');
    @include_once('classes/Superuser.php');

    $temp = new Superuser();
    $temp->setEverything($sid, true);
    //var_dump($temp);
    return $temp;
    echo "generatesuperuser";
    die();
}

//spostare queste funzioni nella classe User



