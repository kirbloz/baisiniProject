<?php
@require_once('php/session.inc.php');
@session_start();


if (!isset($_GET))
    header('location:../index.php');

if (isset($_GET['superuser']) && $_GET['superuser']) {
    if(checkActive()) //se sono dentro come utente rimando indietro
        header('location:../areaUtente.php');
    if (!checkActiveSuper()) //se è scaduta la sessione da superuser mando al login
        header('location:../superlogin.php?error=nosession'); //session
    @require_once('php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());
}else if (isset($_GET['superuser'])){
    if(!checkActive())
        header('location:../login.php?error=nosession');
    @require_once('php/function.inc.php');
    $utente = generateUserOBJ(session_id());
}else //se non esiste superuser nel get allora rimando alla homepage
    header('location:../index.php');

//tutto ok, proseguo con quello che devo fare

require_once('admin/adminfun.inc.php');
if (isset($_GET['matricola'])) {
    fetchMatricola($utente);
    //gli passo l'oggetto del superutente loggato
} else if (isset($_GET['idUser'])) {
    fetchidUser();
}
