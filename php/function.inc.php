<?php

function emptyInputSignup($username, $pwd, $email_address){
    
    $result = null;
    if(empty($username) || empty($pwd) || empty($email_address))
        $result = true;
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
    $values[':username'] = $_POST['username'];
    $values[':email_address'] = $_POST['email_address'];
    $statement = $connection->prepare($query);

    //se query multiple prepara prima e poi fai nel for con i rispetti values
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        header('location:signuppage.php?error=queryfailed');
        /*echo "<div class='error-box centered'>L'esecuzione della query non &egrave; andata a buon fine.</div>";
        var_dump($statement->fetchAll());
        var_dump($values);
        echo $e->getMessage();*/
        die();
    }

    if($statement->rowCount() > 0){
        //var_dump($statement->fetchAll());
        return true;
    }
    return false;
}

function createUser($connection, $username, $pwd, $email_address){
    $values=array();
    $pwd = crypt($pwd, 'sas');

    //preparo la query
    $query = "INSERT INTO user( username, password, email) VALUES(:username, :password, :email_address)";
    $values[':username'] = $_POST['username'];
    $values[':password'] = $pwd;
    $values[':email_address'] = $_POST['email_address'];
    
    $statement = $connection->prepare($query);
    try{
        $statement->execute($values);
    }catch(PDOException $e){
        //header('location:signuppage.php?error=queryfailed');
        var_dump($statement->fetchAll());
        var_dump($values);
        echo $e->getMessage();
        die();
    }
    echo "<div class='centered redirect-login'>L'utente $username &egrave; stato registrato con successo.</div>";
    echo "<a href='../index.php'> Home </a>";
    /*header('Refresh: 3; URL=area_utente.php');*/
    
}

