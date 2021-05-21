<?php
/*
require('../php/function.inc.php');
require_once('../php/header.php');
require_once('adminfun.inc.php');

if (!checkActiveSuper())
    header('location:superlogin.php?error=nosession'); //session
//salvo il power level

$utente = generateSuperuserOBJ(session_id());

?>
<div class="wrapper user-area">
    <div class='color-lightb user-nav'>
        <ul>
            <li><?php
                if (isset($_GET['matricola']))
                    echo "<a href='superuserfetch.php?select=techs'>Torna indietro</a>";
                else if (isset($_GET['idUser']))
                    echo "<a href='superuserfetch.php?select=users'>Torna indietro</a>";
                ?></li>
        </ul>
    </div>
    <?php*/
require_once('adminfun.inc.php');
if (isset($_POST)) {
    var_dump($_POST);
    saveWorkDB($_POST);
    die();
    
} else {
    //probabilmente l'url è stato manomesso, rispedisco indietro
    header('location:../superuserfetch.php?select=works');
}

header('location:../superuserfetch.php?select=works&error=noerror');
