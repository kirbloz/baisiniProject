<?php
    session_start();
    if(!isset($_SESSION['start_time'])){
        header('Location:loginpage.php');
        die;
    }
    else{
        $now = time();
        $time = $now - $_SESSION['start_time'];
        if($time > 3600){
            header('Location:index.php');
            die;
        }
    }
?>