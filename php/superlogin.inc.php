<?php

if (!isset($_POST['submit'])) {
    //se l'utente è arrivato su questa pagina senza submittare il form
    //lo rispedisce indietro
    header('location:../superlogin.php?error=nosubmit');
    die();
} else {
    //includo la classe User
    require('../classes/Superuser.php');

    //salvo i dati POST nelle variabili
    $uid = $_POST['matricola'];
    $pwd = $_POST['pwd'];

    //passo i valori alla funzione della classe user
    $superutente = new Superuser();
    $id = $superutente->login_user($uid, $pwd);

    //var_dump($superutente);
    @session_start();
    if (!createSupersession($id)) {
        header('location:../superlogin.php?error=sessionfailed');
        die();
    }

    //rimando l'utente alla login con il codice corretto
    header('location:../superlogin.php?error=none&username=' . $superutente->getFirstname());
}
