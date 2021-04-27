<?php

    require_once('../db/databasehandler.inc.php');
    require_once('../php/session.inc.php');

    echo "sei in logout.inc.php<br>";
    //session_start();
    //controlla se effettivamente c'è una sessione
    if(!check(false)){
        $user = $_SESSION['userOBJ'];
        var_dump($user);
        deleteSessionTuple($connection, $user->getUsername);
    }else{
        header("location:../logout.php?error=nosession");
    }

    //ok ora funziona però $_SESSION sbabbio perchè la classe user non ha un autoloader????
    //boh guarderò








    echo "<a href='../index.php'>clicca per home</a>";
//header("refresh: 5, URL=../logout.php");