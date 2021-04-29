<?php

    require_once('../db/databasehandler.inc.php');
    require_once('../php/session.inc.php');

    echo "sei in logout.inc.php<br>";
    //controlla se effettivamente c'è una sessione
    if(checkActive()){
        //$tuple = getUserTuple($_SESSION['idSession'], true);
        deleteSessionTuple(session_id());
    }else{
        session_start();
        session_unset();
        session_destroy();
        header("location:../logout.php?error=nosession");
    }

    //ok ora funziona però $_SESSION sbabbio perchè la classe user non ha un autoloader????
    //boh guarderò


    echo "<a href='../index.php'>clicca per home</a>";
//header("refresh: 5, URL=../logout.php");