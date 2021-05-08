<?php

    @include_once('../db/databasehandler.inc.php');
    @include_once('../php/session.inc.php');
    @include_once('../php/function.inc.php');
    //controlla se effettivamente c'è una sessione
    if(checkActive()){
        deleteSessionTuple(session_id());
    }else{
        @session_start();
        session_unset();
        session_destroy();
        header("location:../logout.php?error=nosession");
    }

    if(isset($_POST['submit']) && $_POST['submit'] == "DELETE"){
        deleteUserTuple();
        header("location:../logout.php?error=deletedaccount");
    }else
    //tutto ok, torno a logout
    header("location:../logout.php?error=noerror");
    