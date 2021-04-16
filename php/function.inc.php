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
    if(strlen($username)>20 || preg_match("[@_!#$%^&*()<>?/|}{~:;=^]", $username))
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

    $query = "SELECT * FROM user WHERE id_customer = ?;";
    //prevenire sql injections usando degli statement che runnano senza input dall'utente
    /*$statement = $connection->prepare($query);
    if(!mysqli_stmt_prepare($statement, $query)){
        header('location:signuppage.php?error=stmtfailed');
        die();
    }
    DA FARE SOLO SE ASCENDO COME DIVINITA'
    */
}

function createUser($username){

    
}

