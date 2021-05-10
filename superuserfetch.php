<?php
        @include('php/header.php');
        if(!checkActiveSuper())
            header('location:superlogin.php?error=nosession'); //session

        
        if(!isset($_GET) || !isset($_GET['select'])){
            header('location:areaSuperutente.php');
        }else if($_GET['select'] == 'users'){
            require('fetchSuperuser/fetchUsers.inc.php');
        }else if($_GET['select'] == 'techs'){
            require('fetchSuperuser/fetchTechs.inc.php');
        }else
            echo "parametri errati";
?>	