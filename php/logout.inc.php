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
        if(isset($_GET['isUser']) && $_GET['isUser'])
            $utente = generateUserOBJ(session_id());
        else
            $utente = generateSuperUserOBJ(session_id());
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
    //nei primi due if tutto è ok, faccio redirect
    if(checkActive()){
        deleteSessionTuple(session_id());
        header("location:../logout.php?error=noerror&isUser=true");
    }else if(checkActiveSuper()){
        deleteSupersessionTuple(session_id());
        header("location:../logout.php?error=noerror&isUser=false");
    }else{
        @session_start();
        session_unset();
        session_destroy();
        header("location:/baisiniProject/php/logout.php?error=nosession");
    }


    