<?php
        @include('php/header.php');
        if(!checkActiveSuper())
            header('location:superlogin.php?error=nosession'); //session
?>

<div class="wrapper user-area">

        <div class='color-lightb user-nav'>
            <ul>
                <li><a href="areaSuperutente.php">Torna indietro</a></li>
            </ul>
        </div>
        <br><br>
   

<?php        
        if(!isset($_GET) || !isset($_GET['select'])){
            header('location:areaSuperutente.php');
        }else if($_GET['select'] == 'users'){
            require('fetchSuperuser/fetchUsers.inc.php');
        }else if($_GET['select'] == 'techs'){
            require('fetchSuperuser/fetchTechs.inc.php');
        }else
            echo "parametri errati";
?>	
