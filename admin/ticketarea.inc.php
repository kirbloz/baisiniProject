<?php
require_once('../db/databasehandler.inc.php');
require_once('adminfun.inc.php');

if (isset($_POST)) {
    if (!isset($_POST['submit']))
        header('location:../superuserfetch.php?select=tickets');
    else if ($_POST['submit'] == 'Elimina') {
        if (deleteTicketDB($_POST['id_ticket']) == false) {
            header('location:../superuserfetch.php?select=tickets&error=query');
            die();
        } else
            header('location:../superuserfetch.php?select=tickets&error=noerrordelete');
        die();
    } else if ($_POST['submit'] == 'Modifica Status') {
        if (editTicketDB($_POST['id_ticket'], $_POST['isOpen'], $_POST['id_user']) == false) {
            header('location:../superuserfetch.php?select=tickets&error=query');
        } else
            header('location:../superuserfetch.php?select=tickets&error=noerroredit');
        die();
    }
    //probabilmente l'url/form è stato manomesso, rispedisco indietro
    header('location:../superuserfetch.php?select=tickets');
} else {
    //probabilmente l'url è stato manomesso, rispedisco indietro
    header('location:../superuserfetch.php?select=tickets');
}

header('location:../superuserfetch.php?select=tickets');
die();