<?php

    require_once('db/databasehandler.inc.php');
    require_once('classes/User.php');

class Session{

    private $ID;
    //controllo che esista una sessione, se non esiste invio a login.php
    //se esiste ma è scaduta invio all'index e distruggo la sessione

    public static function check($redirect){
        session_start();
        if(!isset($_SESSION['start_time'])){
            
            if($redirect){
                header('Location:login.php');
                die;
                //ritorno che la sessione non c'è
                return false;
            }

        }else{
            $now = time();
            $duration = $now - $_SESSION['start_time'];
            if($duration > 3600){ //se è da più di un ora, logout
                    header('Location:logout.php');
                    die;
                
                //ritorno che la sessione non c'è
                //return false;
                //lascio fare tutto alla pagina di log out, in caso di sessione scaduta
                //l'unica opzione è SEMPRE log out
                //etc
            }
            //ritorno che la sessione c'è ed è valida
            return true;
        }
    }

    
    

    
}
    

