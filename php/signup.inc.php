<?php

if(!isset($_POST['submit'])){
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:signuppage.php?error=nosubmit');
    die();
}else{
    //elaborazione dati, error handling etc
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $email_address = $_POST['email_address'];
    $id_customer = $_POST['id_customer'];

    require_once 'databasehandler.inc.php';
    require_once 'function.inc.php';

    //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
    //nè false potrebbe non riconoscere l'errore
    if(emptyInputSignup($id_customer, $username, $pwd, $email_address) !== false){
        header('location:signuppage.php?error=emptyinput');
        die();
    }

    if(invalidUserN($username) !== false){
        header('location:signuppage.php?error=invalidusername');
        die();
    }

    if(invalidEmail($email_address) !== false){
        header('location:signuppage.php?error=invalidemail');
        die();
    }

    if(invalidPwd($pwd) !== false){
        header('location:signuppage.php?error=invalidpassword');
        die();
    }

    /*if(pwdMatch($pwd, $repeat_pwd) !== false){
        header('location:signuppage.php?error=pwdsnotmatching');
        die();
    }*/

    if(customerExists($connection, $id_customer) !== false){
        header('location:signuppage.php?error=customeruseralreadyexists');
        die();
    }

    createUser($connection, $id_customer, $username, $pwd, $email_address);

}