<?php

if(!isset($_POST['submit'])){
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../signup.php?error=nosubmit');
    die();
}else{
    //includo la classe User
    require('../classes/User.php');

    //salvo i dati POST nelle variabili
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $repeat_pwd = $_POST['repeat_pwd'];
    $email_address = $_POST['email_address'];

    //passo i valori alla funzione della classe user
    $utente = new User();
    $utente->add_user($username, $pwd, $repeat_pwd, $email_address);
    //unset($_POST);
    die();
}