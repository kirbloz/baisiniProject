<?php
@include_once('session.inc.php');
@include_once('php/session.inc.php');

if (!checkActive())
    header('location:logout.inc.php'); //session
@include('function.inc.php');
$utente = generateUserOBJ(session_id());

if (!isset($_POST['submit'])) {
    //se l'utente è arrivato su questa pagina senza submittare lo rispedisco indietro
    header('location:../userShowcase.php?add=customer');
    die();
} else {
    //se non c'è nessun problema, procedo
    if (!isset($_POST['gender']))
        $_POST['gender'] = NULL;
    $utente->add_Customer($_POST);
}
