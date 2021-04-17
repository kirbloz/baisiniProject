<?php

function emptyInputSignup($id_customer, $username, $pwd, $email_address){
    
    $result = null;
    if(empty($id_customer) || empty($username) || empty($pwd) || empty($email_address))
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
    if(filter_var($email_address, FILTER_VALIDATE_EMAIL))
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

function customerExists($connection, $id_customer){

    //preparo la query per la ricerca e l'array per i valori
    $query = "SELECT * FROM user WHERE id_customer = :id_customer;";
    $values[':id_customer'] = $_POST['id_customer'];
    
    try{
        $statement = $connection->prepare($query);
        if(isset($values))
            $statement->execute($values);
        else
            $statement->execute();
        
    }catch(PDOException $e){
        header('location:signuppage.php?error=queryfailed');
        echo "<div class='error-box centered'>L'esecuzione della query non &egrave; andata a buon fine.</div>";
        die();
    }
    
    
}

function createUser($username){

    
}

