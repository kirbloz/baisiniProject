<?php

if(!isset($_POST['submit'])){
    
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../signup.php?error=nosubmit');
    die();
}else{

    //elaborazione dati, error handling etc
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $repeat_pwd = $_POST['repeat_pwd'];
    $email_address = $_POST['email_address'];
    
    require_once 'databasehandler.inc.php';
    require_once 'function.inc.php';

    //controllo che il risultato sia PER FORZA false, perchè in caso non sia nè true
    //nè false potrebbe non riconoscere l'errore
    if(emptyInputSignup($username, $pwd, $email_address) !== false){
        header('location:../signup.php?error=emptyinput');
        die();
    }

    if(invalidUserN($username) !== false){
        header('location:../signup.php?error=invalidusername');
        die();
    }

    if(invalidEmail($email_address) !== false){
        header('location:../signup.php?error=invalidemail');
        die();
    }

    if(invalidPwd($pwd) !== false){
        header('location:../signup.php?error=invalidpassword');
        die();
    }

    if(pwdMatch($pwd, $repeat_pwd) !== false){
        header('location:../signup.php?error=pwdsnotmatching');
        die();
    }

    if(userExists($connection, $username, $email_address) !== false){
        header('location:../signup.php?error=useralreadyexists');
        die();
    }

    createUser($connection, $username, $pwd, $email_address);
    die();
}