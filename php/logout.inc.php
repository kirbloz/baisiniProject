<?php

    @include_once('../db/databasehandler.inc.php');
    @include_once('../php/session.inc.php');
    @include_once('../php/function.inc.php');
  
    
    if(isset($_POST['submit']) && $_POST['submit'] == "DELETE"){
        if(deleteUserTuple())
            header("location:../logout.php?error=deletedaccount");
        else
            header("location:../logout.php?error=deletedaccount");
    }else if(isset($_POST['submit']) && $_POST['submit'] == "CHANGE"){
        @session_start();
        @include('php/function.inc.php');

        //creo l'utente, controllo l'input e mando la funzione di cambio
        $utente = generateUserOBJ(session_id());
        if(!isset($_POST['pwd']) || !isset($_POST['repeat_pwd']))
            header("location:../userShowcase.php?redirect=changepwd&error=invalidinput");

        $utente->changePWD($_POST['pwd'], $_POST['repeat_pwd']);
        //tutto ok, faccio fare il logout
        header("location:../logout.php?error=changedpwd");
        echo "yea";
        die();
    }

    //eseguo questo pezzo dopo tutto per permettere il funzionamento di generateUserOBJ
    //controlla se effettivamente c'è una sessione e la cancello
    if(checkActive()){
        deleteSessionTuple(session_id());
    }else{
        @session_start();
        session_unset();
        session_destroy();
        header("location:/baisiniProject/php/logout.php?error=nosession");
    }
    //tutto ok, torno a logout
    header("location:../logout.php?error=noerror");
    