<?php
/*
if(!isset($_POST['submit'])){
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../login.php?error=nosubmit');
    die();
}else{*/
    //includo la classe User
    require('../classes/User.php');

    //salvo i dati POST nelle variabili
    $uid = $_POST['username'];
    $pwd = $_POST['pwd'];
    
    
    //passo i valori alla funzione della classe user
    $utente = new User();
    $utente->login_user($uid, $pwd);
    unset($_POST);
    die();
    
    //
    //  aggiungere controllo che non sia già loggato
    //  uhh si
    //
//}