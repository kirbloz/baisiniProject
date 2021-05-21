<?php

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
