<?php

    include_once('../db/databasehandler.inc.php');
    include_once('../php/session.inc.php');
    //controlla se effettivamente c'è una sessione
    if(checkActive()){
        deleteSessionTuple(session_id());
    }else{
        @session_start();
        session_unset();
        session_destroy();
        header("location:../logout.php?error=nosession");
    }

    //tutto ok, torno a logout
    header("location:../logout.php?error=noerror");
    