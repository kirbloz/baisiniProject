<?php

require_once('adminfun.inc.php');
if (isset($_POST)) {

    if (!isset($_POST) == 'submit')
        header('location:../superuserfetch.php?select=works');
    var_dump($_POST);
    saveWorkDB($_POST);
} else {
    //probabilmente l'url è stato manomesso, rispedisco indietro
    header('location:../superuserfetch.php?select=works');
}

echo "work aggiunto";
//header('refresh: 5; url=../superuserfetch.php?select=works&error=noerror');

echo "<a href='../superuserfetch.php?select=works&error=noerror'>back</a>";
