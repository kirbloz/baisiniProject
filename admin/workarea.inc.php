<?php

require_once('adminfun.inc.php');
if (isset($_POST)) {
    if (!isset($_POST['submit']) == 'Aggiungi')
        header('location:../superuserfetch.php?select=works');
    saveWorkDB($_POST);
} else {
    //probabilmente l'url è stato manomesso, rispedisco indietro
    header('location:../superuserfetch.php?select=works');
}
//echo "work aggiunto";
header('location:../superuserfetch.php?select=works&error=noerror');