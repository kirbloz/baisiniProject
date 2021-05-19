<?php
@include('php/header.php');
if (!checkActive())
    header('location:login.php?error=nosession'); //session
@include('php/function.inc.php');
$utente = generateUserOBJ(session_id());


if (!isset($_GET) || !isset($_GET['select'])){
    header('location:login.php?error=nosession'); //accesso illecito tramite modifica url
}

require('user/userfun.inc.php');
if($_GET['select'] == 'tickets')
    printTicketArea($utente);
else if($_GET['select'] == 'works')
    printWorkArea($utente);


?>
</div><!-- per chiudere il div aperto nell'header -->