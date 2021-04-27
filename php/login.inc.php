<?php

if(!isset($_POST['submit'])){
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../login.php?error=nosubmit');
    die();
}else{
    //includo la classe User
    require('../classes/User.php');

    //salvo i dati POST nelle variabili
    $uid = $_POST['username'];
    $pwd = $_POST['pwd'];
    
    
    //passo i valori alla funzione della classe user
    $utente = new User();
    $uid_result = $utente->login_user($uid, $pwd); //qua dentro c'è la createSession

    //il login mi ha ritornato l'array della tupla, lo salvo nella tab sessioni
    try{
        startSession($utente, $uid_result);
    }catch(Exception $e){
        //echo $e;
        header('location:../login.php?error=sessionfailed');
        die();
    }
    

    //rimando l'utente alla login con il codice corretto
    header('location:../login.php?error=none&username='. $username);
    unset($_POST);
    die();
    //aggiungi controllo already logged in
}