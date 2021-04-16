<?php

function emptyInputSignup($id_customer, $username, $pwd, $email_address){
    
    $result = null;
    if(empty($id_customer) || empty($username) || empty($pwd) || empty($email_address)){
        $result = true;
    }else
        $result = false;
    return $result;
}

?>